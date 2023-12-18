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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id('ingredient_id');
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('purchase_price');
            $table->string('amount_unit');
            $table->unsignedBigInteger('stock')->default(0);
            $table->string('image')->default('no-image.png');
            $table->timestamps();

            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
