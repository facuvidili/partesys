<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    public function schedules(){ //relacion uno a muchos entre conceptos y horarios. Todos los días y horarios para un concepto en particular
        return $this->hasMany('App\Models\Schedule');
    }

    public function dailyReports(){ //trae todos los partes asociados a un concepto.
        return $this->belongsToMany('App\Models\DailyReport')->withPivot(['amount','sub_total']);
    }
}
