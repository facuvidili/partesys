<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Consolidation;
use App\Models\Crew;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyReport>
 */
class DailyReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'date' => $this->faker->date(),
            'work_start_date' => $this->faker->date(),
            'work_end_date' => $this->faker->date(),
            'work_start_time' => $this->faker->time(),
            'work_end_time' => $this->faker->time(),           
            'observation' => $this->faker->paragraph(),
            'total' => $this->faker->randomFloat(2, 30000.0, 60000.0),
            'user_id' => User::inrandomorder()->first()->id,
            'consolidation_id' => Consolidation::inrandomorder()->first()->id, //tira error si coinciden los id
            'account_id' => Account::inrandomorder()->first()->id,
            'crew_id' => Crew::inrandomorder()->first()->id
        ];
    }
}
