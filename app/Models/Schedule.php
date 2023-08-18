<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model

{
    use HasFactory;

    public function concept(){ //Relacion uno a muchos inversa. Trae el concepto asociado al horario.
        return $this->belongsTo('App\Models\Concept');
    }
    // date('l,H:i');
}
