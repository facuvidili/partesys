<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CompanySupervisorSeeder::class,             //Companía supervisor 1:1 FUNCIONA
            ContractorCrewsSeeder::class,               //Cotratista con cuadrillas 1:M FUNCIONA
            CompanyAccountsSeeder::class,               //Compania con cuentas 1:M FUNCIONA
            // AccountsContractorsSeeder::class,           //Cuentas y contratistas M:M FUNCIONA
            ExtraordinaryConceptSeeder::class,          //Conceptos extraordinarios FUNCIONA
            // ContractSeeder::class,                      //Contratos FUNCIONA
            ConceptSeeder::class,                       //Conceptos. FUNCIONA
            // ConceptSchedulesSeeder::class,              //Horarios de los conceptos 1:M
            // ConsolidationPurcharseOrdersSeeder::class,  //Consolidación con ordenes de compra 1:M FUNCIONA 
            // DailyReportTasksConceptsSeeder::class,      //Reporte diario con tareas y con los conceptos con cantidad y subtotal. FUNCIONA
            // CostSeeder::class,
         ]);
    }
}
