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
        Schema::create('affiliate_withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('affiliate_id');
            $table->string('invoiceID');
            $table->integer('amount');
            $table->string('payment_method')->nullable();
            $table->string('payment_type')->nullable();
            $table->text('payment_details')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0=pending,1=approved,2=declined');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_withdraws');
    }
};
