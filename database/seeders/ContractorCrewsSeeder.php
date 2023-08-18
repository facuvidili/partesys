<?php

namespace Database\Seeders;

use App\Models\Contractor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractorCrewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractors_names = ['PLUS PETROL', 'TECPETROL', 'TOTAL AUSTRAL', 'PETROBRAS', 'SAN ANTONIO']; //AGREGAR LOS NOMBRES ACÁ DE LAS COONTRATISTAS NUEVAS
        for ($i = 0; $i < count($contractors_names); $i++) {
            $contractor_cuit = fake()->numberBetween(10000000000, 99999999999);
            Contractor::factory()->hasCrews(5)->create([ //5 cuadrillas para cada contratista
                'name' => $contractors_names[$i],
                'cuit' => $contractor_cuit,
            ]);
        }
    }
}
