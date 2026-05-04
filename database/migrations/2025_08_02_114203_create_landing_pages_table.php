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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('banner')->nullable();
            $table->text('banner_title')->nullable();
            $table->text('video')->nullable();
            $table->string('slug');
            $table->longText('short_description');
            $table->longText('description');
            $table->text('review')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->text('image_one')->nullable();
            $table->text('image_two')->nullable();
            $table->text('image_three')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
