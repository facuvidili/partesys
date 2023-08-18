<?php

namespace Database\Seeders;

use App\Models\Contractor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountsContractorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractors = Contractor::all();

        foreach ($contractors as $contractor) {
            $contractor->accounts()->attach([
                rand(1, 22),
                rand(23, 45) //50 cuentas en total
            ]); // dos cuentas por cada contratista
        }
    }
}
