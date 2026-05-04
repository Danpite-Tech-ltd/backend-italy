<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Schema::create('sliders', function (Blueprint $table) {
//            $table->id();
//
//            $table->text('image');
//            $table->string('link')->nullable();
//
//            $table->string('title')->nullable();
//
//            $table->text('text')->nullable();
//            $table->string('btn_name')->nullable();
//            $table->string('btn_link')->nullable();
//
//            $table->tinyInteger('status')->default('1')->comment('1=active,0=inactive');
//
//            $table->timestamps();
//        });

        Slider::insert([
            [
                'image' => 'public/frontend/assets/images/slider/slide-1.jpg',
                'title' => 'Slider 1',
                'link' => '#',
                'text' => 'Slider 1',
                'btn_name' => 'Slider 1',
                'btn_link' => '#',
                'status' => 1,
            ],
            [
                'image' => 'public/frontend/assets/images/slider/slide-2.jpg',
                'title' => 'Slider 2',
                'link' => '#',
                'text' => 'Slider 2',
                'btn_name' => 'Slider 2',
                'btn_link' => '#',
                'status' => 1,
            ],
            [
                'image' => 'public/frontend/assets/images/slider/slide-3.jpg',
                'title' => 'Slider 3',
                'link' => '#',
                'text' => 'Slider 3',
                'btn_name' => 'Slider 3',
                'btn_link' => '#',
                'status' => 1,
            ],
        ]);
    }
}
