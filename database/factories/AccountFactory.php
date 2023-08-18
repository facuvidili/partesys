<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $budget = $this->faker->randomFloat(2, 500000, 200000000);
        $is_deficitary = $this->faker->randomElement([1,0]);
        // if ($is_deficitary === 1) {
        //     $balance = $this->faker->randomFloat(2, -5000000,$budget);
        // } else {
        //     $balance = $this->faker->randomFloat(2,0,$budget);
        // }
        // $budget = number_format($budget,2,',','.');
        // $balance = number_format($balance,2,',','.');
        return [
            'is_deficitary' => $is_deficitary,
            'budget' => $budget,
            'balance' => $budget
        ];
    }
}
