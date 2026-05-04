<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert(
            [
                [
                    'name' => 'Laptop',
                    'slug' => 'laptop',
                    'description' => 'Laptop Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\1.png',
                    'SKU_prefix' => 'LAP',
                    'status' => 1,
                ],
                [
                    'name' => 'Camera',
                    'slug' => 'camera',
                    'description' => 'Camera Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\2.png',
                    'SKU_prefix' => 'CAM',
                    'status' => 1,
                ],
                [
                    'name' => 'Mobiles',
                    'slug' => 'mobiles',
                    'description' => 'Mobiles Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\3.png',
                    'SKU_prefix' => 'MOB',
                    'status' => 1,
                ],
                [
                    'name' => 'Electronics',
                    'slug' => 'electronics',
                    'description' => 'Electronics Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\4.png',
                    'SKU_prefix' => 'ELEC',
                    'status' => 1,
                ],

                [
                    'name' => 'Sound System',
                    'slug' => 'sound-system',
                    'description' => 'Sound System Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\5.png',
                    'SKU_prefix' => 'SOU',
                    'status' => 1,
                ],

                [
                    'name' => 'Smart Watch',
                    'slug' => 'smart-watch',
                    'description' => 'Smart Watch System Description',
                    'image' => 'public\frontend\assets\images\demos\demo-4\cats\6.png',
                    'SKU_prefix' => 'SMART',
                    'status' => 1,
                ],
            ]

        );
    }
}
