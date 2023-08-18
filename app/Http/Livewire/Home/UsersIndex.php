<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'updated_at';
    public $direction = 'desc';

    protected $listeners = ['delete']; 

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where('name','LIKE','%'. $this->search.'%')
        ->orWhereHas('roles',function($q){$q->where('name','LIKE','%'. $this->search.'%');})
        ->orWhere('dni','LIKE','%'. $this->search.'%')
        ->orWhere('email','LIKE','%'. $this->search.'%')
        ->orWhere('phone_number','LIKE','%'. $this->search.'%')
        ->orderBy($this->sort,$this->direction)->paginate(10);

        return view('livewire.home.users-index',compact('users'));
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
    public function delete (User $user){
        $user->delete();
    }

}
