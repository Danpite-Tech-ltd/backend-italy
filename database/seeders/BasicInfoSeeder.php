<?php

namespace Database\Seeders;

use App\Models\BasicInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BasicInfo::updateOrCreate(
            ['id' => 1], // Ensure only one row (id = 1)
            [
                'site_name'            => 'My Awesome Website',
                'dark_logo'            => 'public/logo.png',
                'light_logo'           => 'public/logo.png',
                'phone_1'              => '+880 1711-000000',
                'phone_2'              => '+880 1911-000000',
                'mail'                 => 'info@mywebsite.com',
                'address'              => '123, Example Street, Dhaka, Bangladesh',
                'fav_icon'             => 'public/fav.webp',

                'fb_link'              => 'https://facebook.com/mywebsite',
                'insta_link'           => 'https://instagram.com/mywebsite',
                'twitter_link'         => 'https://twitter.com/mywebsite',
                'youtube_link'         => 'https://youtube.com/@mywebsite',
                'vimeo_link'           => 'https://vimeo.com/mywebsite',
                'linkedin_link'        => 'https://linkedin.com/company/mywebsite',
                'skype_link'           => 'skype:mywebsite?chat',

                'about_text'           => 'This is a sample website built with Laravel. It provides awesome services and solutions.',
                'opening_hours_text'   => 'Mon - Fri: 9:00 AM - 6:00 PM',
                'copyright_text'       => '© ' . date('Y') . ' My Awesome Website. All rights reserved.',
                'product_sku_prefix'   => 'TS',
                'order_invoice_prefix' => 'OR'
            ]);
    }
}
