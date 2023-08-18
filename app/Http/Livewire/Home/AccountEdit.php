<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use App\Models\Company;
use App\Models\Contractor;
use Livewire\Component;

class AccountEdit extends Component
{
    public $account;
    public $budget;
    
    public function render()
    {
        
        $account = $this->account;
        $companies = Company::pluck('name', 'id');
        $contractors = Contractor::all();
        return view('livewire.home.account-edit',compact('account','companies', 'contractors'));
    }
    // public function setBudget($budget){
    //     $this->budget = $budget;
    // }
    // public function formater(){
    //     $this->budget =  number_format($this->budget , 2,',','.');
    // }
}
