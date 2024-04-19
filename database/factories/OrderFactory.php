<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::instance(fake()->dateTimeBetween('-2 months', '+1 months'));

        return [
            'order_code' => fake()->numerify('#######'),
            'ordered_by' => User::inRandomOrder()->where('id', '!=', 1)->first()->id,
            // 'ordered_by' => fake()->unique()->numberBetween(2, User::where('id', '!=', 1)->count()),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->addDays(random_int(0, 14)),
            'penalty' => 0,
            'image' => null,
            'status' => 'pending',
        ];
    }
}
