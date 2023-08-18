<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supervisors = User::whereHas('roles',function($q){$q->where('name','Supervisor');})->get(); //todos los supervisores
        $companies_names =
            [
                'PECOM',
                'YPF',
                'BACKER HUGUES',
                'SUPERIOR',
                'HALLIBURTON SLA'
            ]; //AGREGAR LOS NOMBRES ACÁ DE LAS COMPAÑIAS Y TIENE QUE HABER UNA POR CADA SUPERVISOR

         for ($i = 0; $i < $supervisors->count(); $i++) {
            $company_cuit = fake()->numberBetween(100000000000, 999999999999);
            Company::factory()->create([
                'name' => $companies_names[$i],
                'cuit' => $company_cuit,
                'user_id' => $supervisors[$i]->id
            ]);
        }
    }
}

