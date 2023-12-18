<?php

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('accounts');
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('account_id');
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('balance')->default(0);
            $table->timestamps();
            
            
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
