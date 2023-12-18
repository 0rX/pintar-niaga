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
            $table->id('product_id');
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('company_id');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('sale_price');
            $table->json('recipe')->nullable();
            $table->string('image')->default('no-image.png');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
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
