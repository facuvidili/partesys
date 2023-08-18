<?php

namespace App\Http\Livewire\Home;

use App\Models\Crew;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CrewsIndex extends Component

{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public $sort = 'id';
    public $direction = 'asc';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $crews = Crew::where('id', 'LIKE', '%' . $this->search . '%')
            ->orWhere('amount_members', 'LIKE', '%' . $this->search . '%')
            ->orWhere('hour_price', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('contractor', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction)->paginate(10);

        
        foreach ($crews as $crew) {
           
            if ($crew->activeContract()->isEmpty()) {
                
                if(!$crew->hour_price){
                    $crew->hour_price = 0.00001;
                    $crew->save();
                }
            }
        }

        return view('livewire.home.crews-index', compact('crews'));
    }
    public function order($sort)
    {
        if ($this->sort == $sort) {

            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            } else {
                $this->direction = 'asc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'desc';
        }
    }
}
