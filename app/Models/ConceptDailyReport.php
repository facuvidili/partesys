<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptDailyReport extends Model
{
    protected $fillable = [
        'amount', 'sub_total'
    ];
   protected $table = 'concept_daily_report';
    use HasFactory;
}
