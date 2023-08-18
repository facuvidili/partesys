<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use App\Models\Company;
use App\Models\Crew;
use Livewire\Component;

class ContractsCreate extends Component


{

    public $companies;
    public $selectedCompany;
    public $accounts;
    public $totalPrice;
    public $selectedAccount;
    public $crews;



    public function render()
    {


        $this->companies = Company::pluck('name', 'id');
        $company = Company::find($this->selectedCompany);

        if (!$this->totalPrice) {
            $this->totalPrice = true;
        }
        if ($company) {
            $this->accounts = Account::where('company_id', $company->id)->get();
            // ->whereRaw('budget-balance >=' . $this->totalPrice)->pluck('name', 'id');

            foreach ($this->accounts as $key => $account) {
                if ($this->totalPrice > ($account->balance - $account->totalReserved())) {
                    unset($this->accounts[$key]);
                }
            }
            $this->accounts=$this->accounts->pluck('name', 'id');
        }

        $contractors = $this->selectedAccount ? Account::find($this->selectedAccount)->contractors : null;

        if ($contractors) {
            $contractorIds = [];
            foreach ($contractors as $contractor) {
                $contractorIds[] = $contractor->id;
            }

            $this->crews = Crew::whereIn('contractor_id', $contractorIds)->pluck('id','id');
        //    $crews = Crew::whereIn('contractor_id', $contractorIds);



        //     foreach ($crews as $crew) {
        //         if(($crew->dailyReports()->whereNotNull('consolidation_id'))){
        //             $this->crews[] = $crew->id;
        //         }
        //     }
        //     dd($this->crews);
           
            // ->dailyReports()->whereNotNull('consolidation_id')->pluck('id');

        }



        return view('livewire.home.contracts-create');
    }
}
