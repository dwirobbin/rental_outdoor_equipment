<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('ID_id')->unique()->name();
        $username = str(preg_replace('/\s|\.|\+/', '', $name))->lower();
        $emailDomainName = ['@gmail.com', '@microsoft.com', '@google.com', '@yahoo.com', '@outlook.com'];

        return [
            'name' => $name,
            'username' => $username,
            'email' => $username . fake()->randomElement($emailDomainName),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
            'is_active' => fake()->boolean(70),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
