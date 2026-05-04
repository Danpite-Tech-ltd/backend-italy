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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            // references id on users table

            $table->string('ip')->nullable();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();
            // references id on products table

            $table->foreignId('color_id')
                ->nullable()
                ->constrained('productcolors')
                ->nullOnDelete();
            // references id on colors table

            $table->unsignedBigInteger('variant_id')->nullable();
            $table->foreign('variant_id')
                ->references('id')
                ->on('productvariants')
                ->nullOnDelete();
            // references id on variants table

            $table->integer('quantity')->default(1);
            $table->integer('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
