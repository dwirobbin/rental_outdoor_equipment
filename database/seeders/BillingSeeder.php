<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Billing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Billing::factory(Order::count())->create();
    }
}
