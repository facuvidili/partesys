<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Company;
use App\Models\Consolidation;
use App\Models\Cost;
use App\Models\CostExtra;
use App\Models\Crew;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PurchaseOrders;
use Illuminate\Support\Facades\DB;

class ConsolidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.consolidations.index');
    }
    public function new($crewId, $monthYear)
    { //devolver vista.

        $month = substr($monthYear, 0, 2);
        $year = substr($monthYear, 3, 6);

        $dailyReports = DailyReport::where('crew_id', $crewId)->where(DB::raw('MONTH(work_start_date)'), $month)->where(DB::raw('YEAR(work_start_date)'), $year)->get();
        $companies = Company::all();
        $querys = [];

        foreach ($companies as $company) {

            $query = DB::table('daily_reports as d')
                ->select(DB::raw('d.id, d.account_id,a.company_id,SUM(CASE WHEN c.concept_id = 1 THEN c.sub_total END) as total_normal_hour,SUM(CASE WHEN c.concept_id = 2 THEN c.sub_total END) as total_fifty_hour,SUM(CASE WHEN c.concept_id = 3 THEN c.sub_total END) 
            as total_hundred_hour, SUM(CASE WHEN c.concept_id = 4 THEN c.sub_total END) as total_food'))
                ->join('concept_daily_report as c', 'd.id', '=', 'c.daily_report_id')
                ->join('accounts as a', 'd.account_id', '=', 'a.id')
                ->where('crew_id', $crewId)
                ->where('company_id', $company->id)
                ->where(DB::raw('MONTH(work_start_date)'), $month)
                ->where(DB::raw('YEAR(work_start_date)'), $year)
                ->groupBy('d.account_id')
                ->orderBy('a.company_id')
                ->orderBy('d.account_id')
                ->orderBy('c.concept_id')
                ->get();

            if ($query) {
                $account = [];

                foreach ($query as $q) {
                    $cost = new Cost();
                    if (!empty(Crew::find($crewId)->activeContract()[0])) {
                        $cost->normal_hour = Crew::find($crewId)->activeContract()[0]->total_price / Crew::find($crewId)->activeContract()[0]->months_duration;
                    } else {
                        $cost->normal_hour = $q->total_normal_hour;
                    }
                    $cost->fifty_hour = $q->total_fifty_hour;
                    $cost->hundred_hour = $q->total_hundred_hour;
                    $cost->food = $q->total_food;
                    $cost->account_id = $q->account_id;
                    $cost->current_balance = Account::find($q->account_id)->balance - Account::find($q->account_id)->totalReserved();
                    $cost->concepts = [];
                    $cost->sub_total = $cost->normal_hour + $q->total_fifty_hour + $q->total_hundred_hour + $q->total_food;
                    $cost->total_concepts = 0; //para la comprobación de que no se pase del current_balance
                    $cost = $cost->attributesToArray();
                    $account[$cost['account_id']] = $cost;
                    $querys[$company->id] = $account;
                }
            }
        }
        return view('home.consolidations.new', compact(['crewId', 'month', 'year', 'querys', 'dailyReports']));
    }
}
