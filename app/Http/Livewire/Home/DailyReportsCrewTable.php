<?php

namespace App\Http\Livewire\Home;

use App\Models\Crew;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


class DailyReportsCrewTable extends Component

{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'asc';
    public function render()
    {
       
        $ids=Auth::user()->company->crews();
        

        //SOLO BUSCA POR ID DE CUADRILLA
        $crews = (Crew::where('id', 'LIKE', '%' . $this->search . '%')->whereIn('id', $ids)
        ->orWhere('amount_members','LIKE','%'. $this->search.'%')->whereIn('id', $ids)
        ->orWhere('hour_price','LIKE','%'. $this->search.'%')->whereIn('id', $ids)
        ->orWhereHas('contractor',function($q){$q->where('name','LIKE','%'. $this->search.'%');})->whereIn('id', $ids))
            ->orderBy($this->sort, $this->direction)->paginate(10);
     
            foreach ($crews as $id =>$crew) {
                if($crew->contracts()->first()){     
                    if(!(Account::find($crew->contracts()->first()->account_id)->company->id == Auth::user()->company->id)){
                    unset($crews[$id]);
                }
            }
        return view('livewire.home.daily-reports-crew-table', compact('crews'));
    }
}

    //PARA ORDENAR TABLA
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
            $this->direction = 'asc';
        }
    }

    public function showCalendar($id)
    {
        $this->emit('showCalendar', $id);
    }

}
