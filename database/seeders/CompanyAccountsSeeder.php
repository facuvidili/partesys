<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uno = [
            'Servicios especiales',
            'Fractura'
        ];
        $dos = [
            'Coiled Tubing',
            'Wireline'
        ];
        $tres = [
            'Cementacion',
            'Perforación'
        ];
        $cuatro = [
            'Pulling',
            'Mantenimiento mecánico'
        ];
        $cinco = [
            'Depósito',
            'Limpieza'
        ];

        //Agrego dos cuentas para cada compañia

        $companies = Company::all();
        for ($j = 0; $j < count($uno); $j++) {
            Account::factory()->create([
                'name' => $uno[$j],
                'company_id' => $companies[0]->id
            ]);
        }
        for ($j = 0; $j < count($dos); $j++) {
            Account::factory()->create([
                'name' => $dos[$j],
                'company_id' => $companies[1]->id
            ]);
        }
        for ($j = 0; $j < count($tres); $j++) {
            Account::factory()->create([
                'name' => $tres[$j],
                'company_id' => $companies[2]->id
            ]);
        }
        for ($j = 0; $j < count($cuatro); $j++) {
            Account::factory()->create([
                'name' => $cuatro[$j],
                'company_id' => $companies[3]->id
            ]);
        }
        for ($j = 0; $j < count($cinco); $j++) {
            Account::factory()->create([
                'name' => $cinco[$j],
                'company_id' => $companies[4]->id
            ]);
        }
    }
}
