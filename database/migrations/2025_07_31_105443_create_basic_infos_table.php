<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('basic_infos', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')->nullable();
            $table->text('dark_logo')->nullable();
            $table->text('light_logo')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('mail')->nullable();
            $table->string('address')->nullable();
            $table->string('fav_icon')->nullable();

            $table->text('fb_link')->nullable();
            $table->string('insta_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('vimeo_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('skype_link')->nullable();

            $table->text('about_text')->nullable();
            $table->text('opening_hours_text')->nullable();
            $table->text('copyright_text')->nullable();

            $table->text('newsletter_bgImage')->nullable();
            $table->string('product_sku_prefix')->nullable();
            $table->string('order_invoice_prefix')->nullable();

            //SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            $table->longText('google_schema')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_infos');
    }
};
