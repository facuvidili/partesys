<?php

namespace Database\Seeders;

use App\Models\Concept;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Concept::factory()->create([
            'name' => 'Horas normales',
            'value' => 1
        ]);
        Concept::factory()->create([
            'name' => 'Horas al 50%',
            'value' => 1.5
        ]);
        Concept::factory()->create([
            'name' => 'Horas al 100%',
            'value' => 2
        ]);
        Concept::factory()->create([
            'name' => 'Viandas',
            'value' => 1000
        ]);
        
    }
}
