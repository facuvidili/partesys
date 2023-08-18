<?php

namespace Database\Factories;


use App\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crew>
 */
class CrewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = $this->faker->randomElement([4500.00, 5000.00, 6000.00, 7000.00, 8000.00, 9000.00]);
        return [
            'amount_members' => $this->faker->numberBetween(3,7),
            'hour_price' => $price,
        ];
    }
}
