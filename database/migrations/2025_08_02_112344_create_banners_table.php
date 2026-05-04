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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->text('image');
            $table->text('text')->nullable();

            $table->string('type')->nullable()->default('normal')->comment('normal,offer');

            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();

            $table->string('btn_name')->nullable();
            $table->text('btn_link')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1=active,0=inactive');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
