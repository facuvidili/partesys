<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    public function accounts(){ //Relacion muchos a muchos con cuentas. Devuelve todas las cuentas la cual la contratista está asociada
        return $this->belongsToMany('App\Models\Account');
    }

    public function crews(){ //Relacion uno a muchos con cuadrillas. Devuelve todas las cuadrillas de la contratista
        return $this->hasMany('App\Models\Crew');
    }
}
