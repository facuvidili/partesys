<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_start_date',
        'work_end_date',
        'work_start_time',
        'work_end_time',
        'observation',
        'total'
    ];

    public function user()
    { //Trae el supervisor que cargó el parte.
        return $this->belongsTo('App\Models\User');
    }

    public function consolidation()
    { //Trae la consolidación del parte.
        return $this->belongsTo('App\Models\Consolidation');
    }

    public function account()
    { //Trae la cuenta asociada al parte
        return $this->belongsTo('App\Models\Account');
    }

    public function crew()
    { //Trae la cuadrilla a la cual le pertenece el parte.
        return $this->belongsTo('App\Models\Crew');
    }

    public function tasks()
    { //Relación muchos a muchos entre parte y tareas. Trae todas las tareas asociadas a un parte.
        return $this->hasMany('App\Models\Task');
    }

    public function concepts()
    { //Relación muchos a muchos entre parte y concepto. Trae todos los conceptos asociados a un parte.
        return $this->belongsToMany('App\Models\Concept')->withPivot(['amount','sub_total']);
    }
}
