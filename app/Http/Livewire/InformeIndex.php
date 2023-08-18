<?php

namespace App\Http\Livewire;

use App\Exports\InformeExport;
use App\Models\Account;
use App\Models\Company;
use App\Models\PurchaseOrder;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeIndex extends Component
{
    use WithPagination;
    public $filters = [
        'compania' => '',
        'fromDate' => '1990',
        'toDate' => '2023',
    ];
    public $consulta = [];
    public $companias;
    public $names = array();
    public $totals = array();
    public $balance = array();
    public $percent = array();


    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $this->companias = Company::all();

        if ($this->filters['fromDate'] != '' && $this->filters['toDate'] != '' && intval(substr($this->filters['toDate'], 0, 4)) > 1950) {
            $this->consulta = $this->consulta();
        }
        
        return view('livewire.informe-index');
    }
    public function generateReport()
    {
        return (new InformeExport($this->consulta()))->download('InformeEstadistico'.$this->filters['fromDate'].'_'.$this->filters['toDate'].'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function generatePdf()
    {

        $pdf = (new InformeExport($this->consulta()))->download('InformeEstadistico'.$this->filters['fromDate'].'_'.$this->filters['toDate'].'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        return $pdf;
    }
    public function consulta()
    {
        $sql =
            DB::table('consolidations as cons')->select('c.name as nombreCompania', DB::raw('costs.id,costs.account_id , a.name, a.is_deficitary, a.balance, a.budget, SUM(costs.normal_hour) as total_normal_hour, SUM(costs.fifty_hour) as total_fifty_hour, sum(costs.hundred_hour) as total_hundred_hour, SUM(costs.food) as total_food'))
            ->join('purchase_orders as po', 'cons.id', '=', 'po.consolidation_id')
            ->join('costs', 'costs.purchase_order_id', '=', 'po.id')
            ->join('accounts as a', 'costs.account_id', '=', 'a.id')
            ->join('companies as c', 'a.company_id', '=', 'c.id')
            ->where('c.id', '=', $this->filters['compania'])
            //->where('cons.month', '>=', @substr($this->filters['fromDate'], 5, 7))
            ->where('cons.year', '>=', @substr($this->filters['fromDate'], 0, 4))
            //->where('cons.month', '<=', @substr($this->filters['toDate'], 5, 7))
            ->where('cons.year', '<=', @substr($this->filters['toDate'], 0, 4))
            ->groupBy('costs.account_id')
            ->get();

       
        $this->names=[];
        $this->totals=[];
        $this->balance=[];
        $this->percent=[];
        foreach ($sql as $s) {
            $s->total_concepts = $this->totalConcepts($s->account_id);

           
            $this->names[] = $s->name;
            $this->totals[] = $s->total_normal_hour + $s->total_fifty_hour + $s->total_hundred_hour + $s->total_food + $s->total_concepts->total_extraordinary_concepts + $s->total_concepts->total_discount;;
            $this->balance[] = $s->balance;
            $this->percent[] = (($s->budget-$s->balance)/$s->budget)*100;
            
        }

        $this->dispatchBrowserEvent('refreshChart', ['names' => $this->names, 'totals' => $this->totals, 'balance' => $this->balance, 'percent' => $this->percent]);


        return $sql;
    }

    public function totalConcepts($account_id)
    {
        $concepts = DB::table('consolidations as cons')->select(DB::raw("SUM(CASE WHEN e_c.type='normal' THEN c_e.value END) AS total_extraordinary_concepts , SUM(CASE WHEN e_c.type='descuento' THEN -c_e.value END) AS total_discount"))
            ->join('purchase_orders as po', 'cons.id', '=', 'po.consolidation_id')
            ->join('costs', 'costs.purchase_order_id', '=', 'po.id')
            ->join('accounts as a', 'costs.account_id', '=', 'a.id')
            ->join('companies as c', 'a.company_id', '=', 'c.id')
            ->join('cost_extra as c_e', 'costs.id', '=', 'c_e.cost_id')
            ->join('extraordinary_concepts as e_c', 'c_e.extraordinary_concept_id', '=', 'e_c.id')
            ->where('c.id', '=', $this->filters['compania'])
            ->where('costs.account_id', '=', $account_id)
            ->where('cons.month', '>=', @substr($this->filters['fromDate'], 5, 7))
            ->where('cons.year', '>=', @substr($this->filters['fromDate'], 0, 4))
            ->where('cons.month', '<=', @substr($this->filters['toDate'], 5, 7))
            ->where('cons.year', '<=', @substr($this->filters['toDate'], 0, 4))
            ->orderBy('costs.account_id')
            ->first();



        return $concepts;
    }

    
    public function downloadPdf()
    {
        $pdfContent = PDF::loadView(
            'livewire.home.informe-eventPDF',
            [
                'contador' => Auth::user(),
                'consulta' => $this->consulta,
                'compania' => $this->consulta[0]['nombreCompania'],
                'desde' => $this->filters['fromDate'],
                'hasta' => $this->filters['toDate'],
            ]
        )->setPaper('a3', 'landscape')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "InformeEstadístico_" . $this->filters['fromDate'] . "_" . $this->filters['toDate'] . ".pdf" //cambiar nombre
        );
    }
}
