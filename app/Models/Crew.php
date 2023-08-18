<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Crew extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount_members',
        'hour_price',
    ];

    public function dailyReportsIds()
    {   
        // $accountsIds=[];
        //     foreach (Auth::user()->company->accounts as $account) {
        //         $accountsIds[]=$account->id;
        //     }
        // $dailyReports=DailyReport::where('crew_id','=',$this->id)->whereIn('account_id', $accountsIds)->get()->pluck('id');
        $dailyReports=DailyReport::where('crew_id','=',$this->id)->get()->pluck('id');
       
        return $dailyReports;
    }

    public function lastConsolidationDate()
    {

        $consol=Consolidation::where('crew_id', '=', $this->id)->latest()->get()->first();
        //ENCUENTRA LA ULTIMA CONSOLIDACION DE LA CUADRILLA
      
        return $consol!=null?[$consol->month, $consol->year]:false;
    }

    public function consolidations()
    { //Relación uno a muchos. Muestra todas las consolidaciones para una cuadrilla en particular.
        return $this->hasMany('App\Models\Consolidation');
    }

    public function contractor()
    { //relacion uno a muchos inversa. Devuelve contratista
        return $this->belongsTo('App\Models\Contractor');
    }

    public function dailyReports()
    {
        return $this->hasMany('App\Models\DailyReport');
    }

    public function contracts()
    { //Hacer la logica para que me devuelva el contrato activo de la cuadrilla.
        return $this->hasMany('App\Models\Contract');
    }

    public function activeContract(){

        return Contract::where('crew_id','=',$this->id)->where('end_date','>=', Carbon::today())->get();
    }
    // public function consolidationUnresolved(){
    //     $retVal = false;
    //     if(DailyReport::where('id',$this->crew->id)){

    //     }
    //     return 
    // }  

    public function totalsDailyReportsToConsolidate($month, $year)
    {
        // $firstDayOfMonth = new Carbon($year . '-' . $month . '-01');

        // $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();

        // $dailyReports = DailyReport::where('crew_id', $this->id)->whereBetween('work_start_date', [$firstDayOfMonth, $lastDayofMonth])->get();
        $dailyReports = DailyReport::where('crew_id', $this->id)->where(DB::raw('MONTH(work_start_date)'), $month)->where(DB::raw('YEAR(work_start_date)'), $year)->get();
        // return $dailyReports;
        // return $dailyReports[0]->concepts;

        $purchaseOrders = [
            'companies' => []
        ];

        foreach ($dailyReports as $dailyReport) {


            $idCompany = $dailyReport->account->company->id;
            $idAccount = $dailyReport->account->id;
            foreach ($dailyReport->concepts as $concept) {
                $totalNormalHour = 0;
                $totalFiftyHour = 0;
                $totalHundredHour = 0;
                $totalFood = 0;
                if ($concept->id == 1) {

                    // $totalNormalHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalNormalHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 2) {

                    // $totalFiftyHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalFiftyHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 3) {

                    // $totalHundredHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalHundredHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 4) {

                    // $totalFood = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalFood = $concept->pivot->sub_total;
                }



                if (!array_key_exists($idCompany, $purchaseOrders['companies'])) {

                    $purchaseOrders['companies'][$idCompany] = [
                        'accounts' => []
                    ];

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount] = [
                        'totalNormalHour' => $totalNormalHour,
                        'totalFiftyHour' => $totalFiftyHour,
                        'totalHundredHour' => $totalHundredHour,
                        'totalFood' => $totalFood,
                    ];
                } elseif (array_key_exists($idAccount, $purchaseOrders['companies'][$idCompany]['accounts'])) {

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalNormalHour'] += $totalNormalHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalFiftyHour'] += $totalFiftyHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalHundredHour'] += $totalHundredHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalFood'] += $totalFood;
                } elseif (!array_key_exists($idAccount, $purchaseOrders['companies'][$idCompany]['accounts'])) {

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount] = [
                        'totalNormalHour' => $totalNormalHour,
                        'totalFiftyHour' => $totalFiftyHour,
                        'totalHundredHour' => $totalHundredHour,
                        'totalFood' => $totalFood,
                    ];
                }


                /* foreach (array_keys($accounts) as $idAccount) {
                
            } */
            }
        }
        return $purchaseOrders;
    }
}
