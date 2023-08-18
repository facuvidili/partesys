<?php

namespace Database\Factories;

use App\Models\Crew;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consolidation>
 */
class ConsolidationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'month' => $this->faker->month(),
            'year' => $this->faker->year(),
            //'total' => $this->faker->randomFloat(2, 1000000, 9000000),
            'crew_id' => Crew::inrandomorder()->first()->id,
            'user_id' => User::inrandomorder()->first()->id
        ];
    }
}
