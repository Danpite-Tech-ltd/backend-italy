<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sms_gateways')->insert([
            [
                'type' => 'Bulksmsbd',
                'url' => 'https://api.fastsms.com/send',
                'api_key' => 'FASTSMS_API_KEY',
                'senderID' => 'FastSender',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
