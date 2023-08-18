<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use App\Models\Contractor;
use App\Models\Crew;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DailyReportsAccountTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'asc';
    public $total;
    public $contractor_id;

    public $crew;

    protected $listeners = [
        'reportTotal',
        'contractor',
        'crew'
    ];

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

    public function render()
    {
        $accounts = null;
        if ($this->crew != null) {
        //  dd($this->crew->activeContract());
            if ($this->crew->activeContract()->isEmpty()) {
                // dd('no tiene contrato');
                $accounts =  Account::select(DB::raw('accounts.id, accounts.name, accounts.is_deficitary,accounts.budget,accounts.balance,accounts.company_id'))
                    ->join('account_contractor', 'accounts.id', '=', 'account_contractor.account_id')
                    ->where('accounts.id', 'LIKE', '%' . $this->search . '%')->whereIn('accounts.company_id', [Auth::user()->company->id])->whereIn('contractor_id', [$this->contractor_id])
                    ->orWhere('accounts.name', 'LIKE', '%' . $this->search . '%')->whereIn('accounts.company_id', [Auth::user()->company->id])->whereIn('contractor_id', [$this->contractor_id])
                    ->orWhere('accounts.is_deficitary', 'LIKE', '%' . $this->search . '%')->whereIn('accounts.company_id', [Auth::user()->company->id])->whereIn('contractor_id', [$this->contractor_id])
                    ->orWhere('accounts.budget', 'LIKE', '%' . $this->search . '%')->whereIn('accounts.company_id', [Auth::user()->company->id])->whereIn('contractor_id', [$this->contractor_id])
                    ->orWhere('accounts.balance', 'LIKE', '%' . $this->search . '%')->whereIn('accounts.company_id', [Auth::user()->company->id])->whereIn('contractor_id', [$this->contractor_id])
                    ->orderBy($this->sort, $this->direction)
                    ->paginate(10);
            } else {
                // dd('tiene contrato');
                $accounts = Account::where('id', $this->crew->activeContract()[0]->account_id)->paginate(10);
            }
        }
        return view('livewire.home.daily-reports-account-table', compact('accounts'));
    }

    public function selectAccount(Account $account)
    {

        $this->emit('selectAccount', $account);
    }


    public function reportTotal($total)
    {
        $this->total = $total;
    }
    public function contractor($contractor_id)
    {
        $this->contractor_id = $contractor_id;
    }
    public function crew(Crew $crew)
    {
        if ($crew) {
            $this->crew = $crew;
        } else {
            $this->crew = null;
        }
        $this->render();
    }
}
