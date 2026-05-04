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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('childcategory_id')->nullable()->constrained('child_categories')->nullOnDelete();
            $table->foreignId('product_type_id')->nullable()->constrained()->nullOnDelete();

//            $table->integer('brand_id')->nullable();
//            $table->integer('subcategory_id')->nullable();
//            $table->integer('childcategory_id')->nullable();
//            $table->integer('product_type_id')->nullable();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('thumbnail_img')->nullable();

            $table->decimal('affiliate_commission', 10, 2)->default(0);

            $table->string('SKU')->nullable();
            $table->longText('shipping_return_text')->nullable();
            $table->longText('additional_info_text')->nullable();
            $table->text('youtube_link')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            $table->text('google_schema')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
