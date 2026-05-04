<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('couriers')->insert([
            [
                'type' => 'redx',
                'api_key' => 'your_redx_api_key',
                'secret_key' => 'your_redx_secret_key',
                'url' => 'https://api.redx.com',
                'token' => 'your_redx_token',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'type' => 'pathao',
                'api_key' => 'your_pathao_api_key',
                'secret_key' => 'your_pathao_secret_key',
                'url' => 'https://api.pathao.com',
                'token' => 'your_pathao_token',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'type' => 'steadfast',
                'api_key' => 'your_steadfast_api_key',
                'secret_key' => 'your_steadfast_secret_key',
                'url' => 'https://api.steadfast.com',
                'token' => 'your_steadfast_token',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
