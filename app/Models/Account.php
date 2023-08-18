<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'is_deficitary',
        'budget',
        'balance'
    ];

    public function company(){ //Relacion uno a muchos inversa
        return $this->belongsTo('App\Models\Company');
    }

    public function contractors(){ //relacion muchos a muchos con contratistas
        return $this->belongsToMany('App\Models\Contractor');
    }

    public function contracts(){ //relacion uno a muchos con contratos
        return $this->hasMany('App\Models\Contract');
    }

    public function dailyReports(){ //relacion uno a muchos con partes diarios
        return $this->hasMany('App\Models\DailyReport');
    }

    public function costs(){ //Me devuelve todos los costos para una cuenta en particular
        return $this->hasMany('App\Models\Cost');
    }

    public function totalReserved() {
        $today = Carbon::now();
        $formatedToday = $today->format('Y-m-d');
        $totalContracts =  $this->contracts()->where('end_date','>=', $formatedToday)->sum('total_price');

        $totalDailyReports = $this->dailyReports()->whereNull('consolidation_id')->sum('total');

        return $totalContracts + $totalDailyReports;
    }
    
}
