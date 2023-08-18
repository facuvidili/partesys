<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contract;

class ContractsIndex extends Component
{
    use WithPagination;
    public $search;
    public $sort = 'updated_at';
    public $direction = 'desc';

   
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        // User::whereHas('roles',function($q){$q->where('name','Supervisor');})->get();
        $contracts = Contract::where('crew_id', 'LIKE', '%' . $this->search . '%')->orWhere('start_date', 'LIKE', '%' . $this->search . '%')->orWhere('end_date', 'LIKE', '%' . $this->search . '%')->orWhereHas('account', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })->orWhereHas('crew', function ($q) {
                $q->whereHas('contractor', function ($q) {
                    $q->where('name', 'LIKE', '%' . $this->search . '%');
                });
            })->orWhereHas('account', function ($q) {
                $q->whereHas('company', function ($q) {
                    $q->where('name', 'LIKE', '%' . $this->search . '%');
                });
            })->orderBy($this->sort,$this->direction)->paginate(10);
        return view('livewire.home.contracts-index', compact('contracts'));
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
