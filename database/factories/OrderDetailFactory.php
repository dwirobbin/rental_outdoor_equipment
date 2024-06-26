<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'equipment_id' => fake()->unique()->numberBetween(1, Equipment::count()),
            'amount' => fake()->numberBetween(1, 5),
        ];
    }
}
