<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contract;
use App\Models\Crew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() //Creo 5 contratos para 5 cuadrillas. No tuve en cuenta, por ahora, el tema de que la cuadrilla tenga o no 'null' en el campo 'hour_price'.
    {                     //Se supone que la cuadrilla debe pertenecer a la contratista que trabaja para esa cuenta. No se comtempla por ahora
        $crews = Crew::inRandomOrder()->limit(5)->get(); 
        $accounts = Account::inRandomOrder()->limit(5)->get();
        for ($i = 0; $i < $crews->count(); $i++) {
            Contract::factory()->create([
                    'account_id' => $accounts[$i]->id,
                    'crew_id' => $crews[$i]->id
                ]);
        }
    }
}
