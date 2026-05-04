<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\User;
use Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SmsGatewaySeeder::class);
        $this->call(PaymentGatwaySeeder::class);
        $this->call(CourierSeeder::class);
        $this->call(BasicInfoSeeder::class);
        $this->call(ShippingSeeder::class);

        $this->call(ProductTypeSeeder::class);

        $this->call(BrandSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(VariantSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);

        $this->call(OrderStatusSeeder::class);

        $this->call(SliderSeeder::class);
    }
}
