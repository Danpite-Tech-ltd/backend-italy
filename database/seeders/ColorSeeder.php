<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::insert([
            [
              'name' => 'No Color',
              'slug' => 'no-color',
              'code' => null,

            ],
            [
                'name' => 'Red',
                'slug' => 'red',
                'code' => '#ff0000',
            ],

            [
                'name' => 'Green',
                'slug' => 'green',
                'code' => '#00ff00',

            ],

            [
                'name' => 'Blue',
                'slug' => 'blue',
                'code' => '#0000ff',

            ],
        ]);
    }
}
