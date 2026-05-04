<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            [
                'name' => 'Apple',
                'slug' => 'apple',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
            ],
            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
            ],
            [
                'name' => 'Huawei',
                'slug' => 'huawei',
            ],
            [
                'name' => 'Oppo',
                'slug' => 'oppo',
            ],
            [
                'name' => 'Vivo',
                'slug' => 'vivo',
            ],
            [
                'name' => 'Realme',
                'slug' => 'realme',
            ],
            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
            ],
        ]);
    }
}
