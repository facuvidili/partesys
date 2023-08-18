<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class Company extends Model
{
    use HasFactory;

    public function crews()
    {
        $contractorIds=[];
        $accountIds=[];
        foreach ($this->accounts as $account) {
            $accountIds[]=$account->id;
            foreach ($account->contractors as $contractor) {
                $contractorIds[]=$contractor->id;
            };
        }

        $crews= Crew::where('hour_price','>',0.00001)->whereIn('contractor_id', $contractorIds)
        ->orWhere('hour_price',null)->whereIn('contractor_id', $contractorIds)->get();
       
       
        $crewIds=[];
        foreach ($crews as $crew) {
            $crewIds[]=$crew->id;
        }

        return $crewIds;
    }

    public function accounts()
    { 
        return $this->hasMany('App\Models\Account');
    }
    public function user()
    {
        return $this->belongsTo('App\Moldels\User');
    }
}
