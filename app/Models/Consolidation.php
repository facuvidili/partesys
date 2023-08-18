<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consolidation extends Model
{
    use HasFactory;
    protected $fillable = [
        'month',
        'year'
    ];


    public function user()
    {  //relacion uno a muchos inversa. Devuelve el usuario de la consolidacion
        return $this->belongsTo('App\Models\User');
    }

    public function crew()
    { //Relacion uno a muchos inversa. Devuelve la cuadrilla de la consolidacion
        return $this->belongsTo('App\Models\Crew');
    }

    public function purchaseOrders()
    { //Relación uno a muchos. Devuelve todas las ordenes de compra de la consolidacion
        return $this->hasMany('App\Models\PurchaseOrder');
    }

    public function dailyReports()
    { //Relacion uno a muchos. Devuelve todos los partes de la consolidacion.
        return $this->hasMany('App\Models\DailyReport');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->purchaseOrders as $purchaseOrder) {
            $total += $purchaseOrder->total();
        }
        return $total;
    }
}
