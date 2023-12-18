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
        //Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('profilepicture')->nullable();
            $table->enum('gender', ['male','female'])->nullable();
            $table->enum('is_active', ['true','false'])->default('true');
            $table->string('password');
            $table->string('role', ['staff','manager'])->default('staff');
            $table->rememberToken();
            $table->timestamps();
            
            //Connects this table with Positions table
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
