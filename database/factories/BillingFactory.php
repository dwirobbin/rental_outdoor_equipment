<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Between now and 50 days ago
        $startDate = Carbon::instance(fake()->dateTimeBetween('-3 months', '+1 months'));

        return [
            'order_id' => fake()->unique()->randomElement(Order::pluck('id')->toArray()),
            // 'created_date' => Carbon::now()->subDays(7)->startOfWeek(),
            // 'due_date' => Carbon::now()->subDays(7)->endOfWeek(),
            'created_date' => $startDate,
            'due_date' => (clone $startDate)->addDays(7),
            'total' => fake()->numberBetween(50000, 100000),
            'image' => null,
            'status' => 'unpaid',
        ];
    }
}
