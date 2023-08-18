<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'normal_hour' => $this->faker->randomFloat(2, 5000, 10000),
            'fifty_hour' => $this->faker->randomFloat(2, 5000, 10000),
            'hundred_hour' => $this->faker->randomFloat(2, 5000, 10000),
            'food' => $this->faker->randomFloat(2, 5000, 10000),
            'purchase_order_id' => PurchaseOrder::inrandomorder()->first()->id,
            'account_id' => Account::inrandomorder()->first()->id,
        ];
    }
}
