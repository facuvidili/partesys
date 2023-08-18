<?php

namespace Database\Seeders;

use App\Models\Cost;
use App\Models\ExtraordinaryConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $extraordinary_concepts = ExtraordinaryConcept::all();
        Cost::factory(20)->hasAttached($extraordinary_concepts,['value'=> 3000,])->create();
    }
}
