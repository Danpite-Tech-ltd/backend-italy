<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::insert([
            [
                'status_name' => 'Pending',
                'status' => 1,
            ],
            [
                'status_name' => 'Processing',
                'status' => 1,
            ],
            [
                'status_name' => 'Shipped',
                'status' => 1,
            ],
            [
                'status_name' => 'Delivered',
                'status' => 1,
            ],
            [
                'status_name' => 'Cancelled',
                'status' => 1,
            ],
            [
                'status_name' => 'Returned',
                'status' => 1,
            ],
            [
                'status_name' => 'In Courier',
                'status' => 1,
            ]
        ]);

    }
}
