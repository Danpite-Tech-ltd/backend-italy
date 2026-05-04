<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin= [
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'ref_code' => null,
        ];

        $user = [
            'name' => 'User XYZ',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'ref_code' => null,
        ];

        $vendor = [
            'name' => 'vendor XYZ',
            'email' => 'vendor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'ref_code' => null,
        ];

        $affiliate = [
            'name' => 'Affiliate',
            'email' => 'affiliate@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'ref_code' => rand(10000000, 99999999),
            ];

        $users=[$admin, $user, $vendor, $affiliate];

        foreach($users as $user){
            User::create($user);
        }
    }
}
