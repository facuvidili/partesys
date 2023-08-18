<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $fillable = [
        'normal_hour',
        'fifty_hour',
        'hundred_hour',
        'food'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function extraordinaryConcepts()
    {
        return $this->belongsToMany('App\Models\ExtraordinaryConcept', 'cost_extra')->withPivot('value');
    }

    public function totalExtraordinaryCosts($type)
    {
        $totalExtraordinaryConcepts = 0;

        foreach ($this->extraordinaryConcepts as $extraordinaryConcept) {

            if ($extraordinaryConcept->type == $type) {
                $totalExtraordinaryConcepts += $extraordinaryConcept->pivot->value;
            }
        }
        return $totalExtraordinaryConcepts;
    }

    public function total()
    {
        return $this->normal_hour
            + $this->fifty_hour
            + $this->hundred_hour
            + $this->food
            + $this->totalExtraordinaryCosts('normal')
            - $this->totalExtraordinaryCosts('descuento');
    }
}
