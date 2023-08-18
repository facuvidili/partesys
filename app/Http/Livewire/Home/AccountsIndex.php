<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class AccountsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'asc';
    protected $listeners = ['delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $accounts = Account::where('id', 'LIKE', '%' . $this->search . '%')
            ->orWhere('name', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('company', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction)->paginate(15);
        return view('livewire.home.accounts-index', compact('accounts'));
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
    public function delete(Account $account)
    {
        $account->delete();
    }
}
