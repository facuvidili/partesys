<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

    protected $fillable = [
        'start_date',
        'months_duration',
        'end_date',
        'total_price',
    ];

    use HasFactory;

    public function account()
    { //Relación uno a muchos inversa. Devuelve la cuenta del contrato
        return $this->belongsTo('App\Models\Account');
    }

    public function crew()
    { // Relacion uno a muchos inversa. Devuelve la cuadrilla del contrato.
        return $this->belongsTo('App\Models\Crew');
    }
}
