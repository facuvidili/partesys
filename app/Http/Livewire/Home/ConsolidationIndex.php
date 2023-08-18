<?php

namespace App\Http\Livewire\Home;

use App\Models\Consolidation;
use Livewire\Component;
use Livewire\WithPagination;

class ConsolidationIndex extends Component
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
        $consolidations = Consolidation::where('crew_id','LIKE', '%' . $this->search . '%')
            ->orWhere('year', 'LIKE', '%' . $this->search . '%')
            ->orWhere('month', 'LIKE', '%' . $this->search . '%')
            ->orWhere('id', 'LIKE', '%' . $this->search . '%')
            ->orWhere('crew_id', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('crew',function($q){$q->whereHas('contractor',function($q){$q->where('name','LIKE','%'. $this->search.'%');});})
            ->orderBy($this->sort, $this->direction)->paginate(10);

        return view('livewire.home.consolidation-index', compact('consolidations'));
    }
    public function order($sort)
    {
        if ($this->sort == $sort) {

        if ($this->direction == 'asc') {
            $this->direction = 'desc';
        } else {
            $this->direction = 'asc';
        }
    }else{
            $this->sort = $sort;
            $this->direction = 'desc';
        }
    }
}
