<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUsers = [
            // Admin
            [
                'name'              => 'Admin',
                'username'          => 'admin',
                'email'             => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 1,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Customer
            [
                'name'              => 'Customer',
                'username'          => 'customer',
                'email'             => 'customer@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'photo'             => null,
                'role_id'           => 2,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],
        ];

        $newDefaultUsers = [];
        for ($i = 0; $i < count($defaultUsers); $i++) {
            $newDefaultUsers[] = $defaultUsers[$i];
        }

        foreach (array_chunk($newDefaultUsers, 1000) as $newDefaultUser) {
            User::insert($newDefaultUser);
        }

        User::factory(10)->create();
    }
}