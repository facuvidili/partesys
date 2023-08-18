<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'time',
    ];

    public function dailyReport(){ //Trae el parte de una tarea en particular.
        return $this->belongsTo('App\Models\DailyReport');
    }
}
