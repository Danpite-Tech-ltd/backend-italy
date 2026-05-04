<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Variant::insert([
            [
              'name' => 'No Variant',
            ],
            [
                'name' => 'XL',
            ],

            [
                'name' => 'L',
            ],

            [
                'name' => 'M',
            ]
        ]);
    }
}
