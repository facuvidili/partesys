<?php

namespace Database\Seeders;

use App\Models\Consolidation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsolidationPurcharseOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Consolidation::factory(100)->hasPurchaseOrders(2)->create();
    }
}
