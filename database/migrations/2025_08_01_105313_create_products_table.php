<?php

use App\Models\Product;
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
        Schema::create(Product::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Product::NAME);
            $table->string(Product::SLUG)->unique();
            $table->string(Product::SKU)->unique();
            $table->text(Product::DESCRIPTION)->nullable();
            $table->string(Product::DEFAULT_IMAGE_PATH)->nullable();
            $table->integer(Product::PRICE);
            $table->integer(Product::DISCOUNTED_PRICE)->nullable();
            $table->integer(Product::STOCK)->default(0);
            $table->json('product_information')->nullable();
            // $table->foreignIdFor(Category::class)->nullable();
            // $table->foreignIdFor(Brand::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Product::TABLE);
    }
};
