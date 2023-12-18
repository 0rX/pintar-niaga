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
        Schema::create('cashins', function (Blueprint $table) {
            $table->id('cash_in_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('company_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('total_amount');
            $table->timestamps();

            $table->foreign('account_id')->references('account_id')->on('accounts')->onDelete('cascade');
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashins');
    }
};
