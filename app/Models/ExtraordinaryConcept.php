<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraordinaryConcept extends Model
{
    use HasFactory;

    public function costs(){ //Trae todas costos de un concepto extraordinario en particular.
        return $this->belongsToMany('App\Models\Cost','cost_extra')->withPivot('value');
    }

}
