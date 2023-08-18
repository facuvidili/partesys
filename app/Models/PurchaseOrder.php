<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function consolidation()
    { //Relacion uno a muchos inversa. Trae la consolidación de la orden de compra.
        return $this->belongsTo('App\Models\Consolidation');
    }

    /* public function company(){ //Relación uno a muchos inversa. trae la compañia a la cual pertenece la orden de compra (importante)
        return $this->belongsTo('App\Models\Company');
    } */

    public function extraordinaryConcepts()
    { //Trae los conceptos extraordinarios de la orden de compra.
        return $this->belongsToMany('App\Models\ExtraordinaryConcept')->withPivot('value');
    }


    public function costs()
    { //Me devuelve todos los costos para una orden de compra en particular
        return $this->hasMany('App\Models\Cost');
    }

    public function total()
    {
        $totalPurchaseOrder = 0;

        foreach ($this->costs as $cost) {
            $totalPurchaseOrder += $cost->total();
        }
        return $totalPurchaseOrder;
    }

    public function totalExtraordinaryConcepts($type)
    {
        $totalExtraordinaryConcepts = 0;
    
        foreach ($this->costs as $cost) {
            foreach ($cost->extraordinaryConcepts->where('type', $type) as $extraordinaryConcept) {
                $totalExtraordinaryConcepts += $extraordinaryConcept->pivot->value;
            }
        }
        
        return $totalExtraordinaryConcepts;
    }

    public function companyName()
    {
        $cost = $this->costs->first();

        return $cost->account->company->name;
    }
}
