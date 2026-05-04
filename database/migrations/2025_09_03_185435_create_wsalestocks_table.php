<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsalestocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsalestocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wsale_product_id')->constrained('wsaleproducts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('product_name')->nullable();
            $table->integer('size_id')->nullable();
            $table->string('size')->nullable();
            $table->integer('wsale');
            $table->integer('stock');
            $table->integer('initial_stock');
            $table->integer('total_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wsalestocks');
    }
}
