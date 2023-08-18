<?php

namespace Database\Factories;

use App\Models\Crew;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_date = "2022-12-01";
        $months_duration = $this->faker->numberBetween(2,5);
        $end_date = strtotime('+'.$months_duration.'month', strtotime($start_date));
        $end_date = date('Y-m-d',$end_date);
         return [
            'start_date' => $start_date,
            'months_duration' => $months_duration,
            'end_date' => $end_date,
            'total_price' => $this->faker->randomFloat(2, 10000, 5000000),
        ];
    }
}
