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
        Schema::create('used_ingredients', function (Blueprint $table) {
            $table->id('sold_ingredient_id');
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('quantity');
            $table->timestamps();

            $table->foreign('sale_id')->references('sale_id')->on('sales')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('ingredient_id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_ingredients');
    }
};
