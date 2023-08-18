<?php

namespace Database\Seeders;

use App\Models\Concept;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptSchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $horas_normales = Concept::where('name', 'Horas normales')->get()->first()->id;
        $horas_50 = Concept::where('name', 'Horas al 50%')->get()->first()->id;
        $horas_100 = Concept::where('name', 'Horas al 100%')->get()->first()->id;
        $concepts_id = [$horas_100, $horas_normales, $horas_50, $horas_100];
        $days = ['Mon', 'Tue', 'Wes', 'Thu', 'Fri'];
        $hours = ['00:00:00', '08:00:00', '17', '20'];
        for ($j = 0; $j < count($days); $j++) {
            for ($i = 0; $i < 4; $i++) {
                $end_time = ($i != 3) ? $hours[$i + 1] : $hours[0];
                Schedule::factory()->create([
                    'day' => $days[$j],
                    'start_time' => $hours[$i],
                    'end_time' => $end_time,
                    'concept_id' => $concepts_id[$i]
                ]);
            }
        }
        Schedule::factory()->create([
            'day' => 'Sat',
            'start_time' => '00:00:00',
            'end_time' => '23:00:00',
            'concept_id' => $horas_100
        ]);
        Schedule::factory()->create([
            'day' => 'Sunday',
            'start_time' => '00:00:00',
            'end_time' => '23:59:00',
            'concept_id' => $horas_100
        ]);
    }
}
