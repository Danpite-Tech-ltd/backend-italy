<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatwaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_gateways')->insert([
            [
            'type' => 'sslcommerz',
            'app_key' => 'your_sslcommerz_app_key',
            'app_secret' => 'your_sslcommerz_app_secret',
            'username' => 'sslcommerz_username',
            'password' => 'sslcommerz_password',
            'store_id' => 'store_id',
            'store_password' => 'store_password',
            'base_url' => 'https://securepay.sslcommerz.com',
            'success_url' => 'https://yourdomain.com/payment/success',
            'return_url' => 'https://yourdomain.com/payment/fail',
            'prefix' => 'TXN',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'type' => 'bkash',
            'app_key' => 'your_bkash_app_key',
            'app_secret' => 'your_bkash_app_secret',
            'username' => 'bkash_username',
            'password' => 'bkash_password',
            'store_id' => 'store_id',
            'store_password' => 'store_password',
            'base_url' => 'https://sandbox.bka.sh',
            'success_url' => 'https://yourdomain.com/payment/success',
            'return_url' => 'https://yourdomain.com/payment/fail',
            'prefix' => 'TXN',
            'created_at' => now(),
            'updated_at' => now(),
        ]
            ]
        );
    }
}
