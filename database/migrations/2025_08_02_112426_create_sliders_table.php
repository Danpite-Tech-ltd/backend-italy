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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            $table->text('image');
            $table->string('link')->nullable();

            $table->string('title')->nullable();

            $table->text('text')->nullable();
            $table->string('btn_name')->nullable();
            $table->string('btn_link')->nullable();

            $table->tinyInteger('status')->default('1')->comment('1=active,0=inactive');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
