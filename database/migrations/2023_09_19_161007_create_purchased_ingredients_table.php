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
        Schema::create('purchased_ingredients', function (Blueprint $table) {
            $table->id('purchased_ingredients_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('amount');
            $table->timestamps();

            $table->foreign('purchase_id')->references('purchase_id')->on('purchases')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('ingredient_id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchased_ingredients');
    }
};
