<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::insert([
            [
                'name' => 'New Arrivals',
                'slug' => 'new-arrivals',
                'description' => 'Product Type 1 Description',
                'status' => 1,
            ],
            [
                'name' => 'Trending Products',
                'slug' => 'trending-products',
                'description' => 'Product Type 2 Description',
                'status' => 1,
            ],
            [
                'name' => 'Recommended',
                'slug' => 'recommended',
                'description' => 'Product Type 3 Description',
                'status' => 1,
            ]

        ]);
    }
}
