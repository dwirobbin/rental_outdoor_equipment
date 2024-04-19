<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $methods = ['Dana', 'Gopay', 'Ovo'];

        return [
            'name' => fake()->unique()->randomElement($methods),
            'number' => fake()->unique()->randomElement([fake()->numerify('############'), fake()->creditCardNumber()]),
            'photo' => null,
            // 'photo' => fake()->unique()->image(dir: public_path('storage/image/payment-methods'), width: 420, height: 300, fullPath: false),
        ];
    }
}
