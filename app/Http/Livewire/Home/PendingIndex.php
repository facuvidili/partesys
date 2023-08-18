<?php

namespace App\Http\Livewire\Home;

use App\Models\Consolidation;
use App\Models\Crew;
use App\Models\DailyReport;
use Livewire\Component;
use Livewire\WithPagination;

class PendingIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        /*
        $accounts = Account::join('companies', 'id', '=','%'. $this->search . '%')
        ->where('name','LIKE','%'. $this->search.'%')
        ->select('accounts.')
        ->orderBy($this->sort,$this->direction)->paginate(10);
        */

        // id, nro cuadrilla, mes, anio, 
        // total, compania, 

        $crews = Crew::all()->dailyReports->where('consolidation_id', null); 

        $consolidations = Consolidation::where('crew_id', )
        ->where('year', 'LIKE', '%' . $this->search . '%')
        ->where('month', 'LIKE', '%' . $this->search . '%')
        ->orWhere('id', 'LIKE', '%' . $this->search . '%')
        ->orWhere('crew_id', 'LIKE', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)->paginate(10);

        /* $accounts = Account::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('id', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('company', function($q) {$q->where('name', 'LIKE', '%' . $this->search . '%');})
            ->orderBy($this->sort, $this->direction)->paginate(10);
 */
        return view('livewire.home.consolidations-index', compact('consolidations'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}
