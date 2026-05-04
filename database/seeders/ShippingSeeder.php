<?php

namespace Database\Seeders;

use App\Models\ShippingCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingCharge::insert(
            [
                [
                    'area_name' => 'Inside Dhaka',
                    'delivery_charge' => 70,
                    'status' => 1,
                ],
                [
                    'name' => 'Outside Dhaka',
                    'price' => 120,
                    'status' => 1,
                ],
            ]
        );
    }
}
