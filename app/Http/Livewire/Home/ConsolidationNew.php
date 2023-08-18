<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use App\Models\Consolidation;
use App\Models\Cost;
use App\Models\Crew;
use App\Models\Company;
use App\Models\CostExtra;
use App\Models\DailyReport;
use App\Models\ExtraordinaryConcept;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use stdClass;

class ConsolidationNew extends Component

{
    public $crew;
    public $month;

    public $year;

    public $company_id;

    public $account_id;
    public $openConcepts = true;

    public $exConceptId;
    public $exConceptValue;

    public $querys;

    public $prueba;
    public $dailyReports;

    public $currentBalance;
    public $exConcepts;

    protected $listeners = ['store'];

    public function mount(Crew $crewId, $month, $year, $querys, $dailyReports)
    {
        $this->crew = $crewId;
        $this->month = $month;
        $this->year = $year;
        $this->querys = $querys;
        $this->dailyReports = $dailyReports;
        $this->exConcepts = ExtraordinaryConcept::all();
    }
    public function render()
    {
        return view('livewire..home.consolidation-new');
    }

    public function addExConcept($account_id, $company_id)
    {
        if (!Account::find($account_id)->is_deficitary) {
            $this->validate([
                // 'exConceptValue' => 'required|numeric|between:$1,$'.number_format($this->querys[$company_id][$account_id]['current_balance'], 2, ',', '.'),
                'exConceptValue' => 'required|numeric|between:1,'.$this->querys[$company_id][$account_id]['current_balance'],
                'exConceptId' => 'required'
            ]);   
        }else{
            $this->validate([
                'exConceptId' => 'required'
            ]); 
        }

        if (!array_key_exists($this->exConceptId, $this->querys[$company_id][$account_id]['concepts'])) {
            $exConcept = [];
            $exConcept['value'] = $this->exConceptValue;
            $exConcept['extraordinary_concept_id'] = $this->exConceptId;
            $exConcept['name'] = ExtraordinaryConcept::find($this->exConceptId)->name;
            $exConcept['type'] = ExtraordinaryConcept::find($this->exConceptId)->type;
            $this->querys[$company_id][$account_id]['concepts'][$this->exConceptId] = $exConcept; //agrego el concepto
            if ($exConcept['type'] == 'normal') {
                if (!($this->exConceptValue + $this->querys[$company_id][$account_id]['total_concepts'] > $this->querys[$company_id][$account_id]['current_balance'] + $this->querys[$company_id][$account_id]['total_concepts']) || (Account::find($account_id)->is_deficitary)) {
                    $this->querys[$company_id][$account_id]['total_concepts'] += $this->exConceptValue;
                    $this->querys[$company_id][$account_id]['sub_total'] += $this->exConceptValue;
                    $this->querys[$company_id][$account_id]['current_balance'] -= $this->exConceptValue;
                } else {
                    $this->dispatchBrowserEvent('higherValueBalance');
                    unset($this->querys[$company_id][$account_id]['concepts'][$this->exConceptId]);
                }
            } elseif (!($this->exConceptValue > $this->querys[$company_id][$account_id]['sub_total'])) {
                $this->querys[$company_id][$account_id]['sub_total'] -= $this->exConceptValue;
                $this->querys[$company_id][$account_id]['total_concepts'] -= $this->exConceptValue;
                $this->querys[$company_id][$account_id]['current_balance'] += $this->exConceptValue;
            } else {
                $this->dispatchBrowserEvent('higherValue');
                unset($this->querys[$company_id][$account_id]['concepts'][$this->exConceptId]);
            }
            $this->reset(['exConceptId', 'exConceptValue']);
        } else {
            $this->dispatchBrowserEvent('conceptRepit');
        }
    }

    public function removeExConcept($company_id, $account_id, $key)
    {
        $concept = $this->querys[$company_id][$account_id]['concepts'][$key];

        if ($concept['type'] == 'normal') {
            $this->querys[$company_id][$account_id]['total_concepts'] -= $concept['value'];
            $this->querys[$company_id][$account_id]['sub_total'] -= $concept['value'];
            $this->querys[$company_id][$account_id]['current_balance'] += $concept['value'];
        } else {
            $this->querys[$company_id][$account_id]['total_concepts'] += $concept['value'];
            $this->querys[$company_id][$account_id]['sub_total'] += $concept['value'];
            $this->querys[$company_id][$account_id]['current_balance'] -= $concept['value'];
            
        }
        unset($this->querys[$company_id][$account_id]['concepts'][$key]);
    }

    public function store()
    {
        $consolidation = Consolidation::create([
            'month' => $this->month,
            'year' => $this->year,
        ]);
        $consolidation->user()->associate(Auth::user());
        $consolidation->crew()->associate($this->crew);
        $consolidation->save();
        $this->prueba['consolidations'] = $consolidation;

        foreach ($this->querys as $company_id => $query) {
            $purchaseOrder = PurchaseOrder::create();
            $purchaseOrder->consolidation()->associate($consolidation);
            $this->prueba['purchaseOrders'] = $purchaseOrder;
            $purchaseOrder->save();

            foreach ($query as $account_id => $q) {
                $cost = Cost::create([
                    'normal_hour' => $q['normal_hour'],
                    'fifty_hour' => $q['fifty_hour'],
                    'hundred_hour' => $q['hundred_hour'],
                    'food' => $q['food'],
                ]);
                $cost->purchaseOrder()->associate($purchaseOrder);
                $cost->account()->associate(Account::find($account_id));
                $cost->save();
                
                Account::find($account_id)->update([
                    'balance' =>$q['current_balance']
                ]);

                foreach ($q['concepts'] as $conceptExtra) {
                    $cost->extraordinaryConcepts()->attach([
                        $conceptExtra['extraordinary_concept_id'] => ['value' => $conceptExtra['value']]
                    ]);
                    
                }
                $cost->save();
                // $this->prueba['costs'] = $cost;
                // $this->prueba['extraordinary_concepts'] = $cost->extraordinaryConcepts();
            }
        }
        foreach ($this->dailyReports as $dr) {
            $dr->consolidation()->associate($consolidation);
            $dr->save();
        }
        return redirect()->route('home.consolidations.index')->with('info', 'La consolidación se ha generado correctamente.');
    }
}