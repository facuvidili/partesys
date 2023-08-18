<?php

namespace Database\Factories;

use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence(),
            'time' => $this->faker->randomElement(['3', '2', '1', '0.25', '0.75']),
        ];
    }
}
