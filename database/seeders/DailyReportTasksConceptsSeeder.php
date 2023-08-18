<?php

namespace Database\Seeders;

use App\Models\Concept;
use App\Models\DailyReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyReportTasksConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concepts = Concept::all();
        // DailyReport::factory(100)->hasTasks(2)->hasAttached($concepts,['sub_total'=> 1000,'amount'=>3.0])->create();
        DailyReport::factory(30)->hasTasks(3)->hasAttached($concepts,['sub_total'=> 1000,'amount'=>3.0])->create([
            'consolidation_id' =>null,
            'work_start_date' => '2022/10/13',
            'crew_id' => 1
        ]);
    }
}
