<?php

namespace Database\Seeders;

use App\Models\ExtraordinaryConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraordinaryConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExtraordinaryConcept::factory()->create([
            'name' => 'Combustible',
            'type' => 'normal'
        ]);
        ExtraordinaryConcept::factory()->create([
            'name' => 'Descuento operario',
            'type' => 'descuento'
        ]);
        ExtraordinaryConcept::factory()->create([
            'name' => 'Materiales',
            'type' => 'normal'
        ]);
    }
}
