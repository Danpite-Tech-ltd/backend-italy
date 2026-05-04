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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('invoiceID'); // Invoice ID
            $table->string('entry_complete')->nullable(); // Website ID
            $table->string('web_id')->nullable(); // web ID
            $table->string('user_id')->nullable(); // user ID
            $table->integer('customer_id')->nullable(); // Customer ID
            $table->string('order_status_id')->nullable(); // Order Status
            $table->string('payment')->nullable(); // Cash On Delivery Or Online
            $table->text('customer_note')->nullable(); // Customer Note
            $table->string('memo')->nullable(); // Website ID
            $table->string('payment_method')->nullable();
            $table->integer('payment_type_id')->nullable(); // Payment Type ID
            $table->string('payment_id')->nullable(); // Payment Received Number
            $table->string('paymentAgentNumber')->nullable(); // Payment Sender Number
            $table->integer('courier_id')->nullable(); // Courier ID
            $table->integer('subtotal');  // Total
            $table->integer('total');  // Total
            $table->string('area_name')->nullable(); // Area Name
            $table->integer('delivery_charge')->nullable(); // Delivery Charge
            $table->integer('discount_charge')->nullable(); // Discount Charge
            $table->integer('shipping_charge_id')->nullable(); // Discount Charge
            $table->integer('payment_amount')->nullable(); // Payment Amount
            $table->date('order_date');  // Order Date
            $table->date('delivery_date')->nullable(); // Delivery Date
            $table->date('complete_date')->nullable(); // Complete Date
            $table->date('last_updated')->nullable(); // last updated Date
            $table->integer('affiliate_id')->nullable(); // Affiliate ID
            $table->integer('admin_id')->nullable();  // User ID
            $table->integer('store_id')->nullable(); // Store ID

            $table->string('consignmentID')->nullable();
            $table->string('trackingID')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
