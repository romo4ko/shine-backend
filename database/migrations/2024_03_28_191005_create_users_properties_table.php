<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->text('text')->nullable();
            $table->date('birthdate')->nullable();
            $table->foreignId('sex')->nullable();
            $table->foreignId('city')->constrained('cities')->nullable();

            $table->foreignId('purpose')->constrained('properties')->nullable()->comment('Цель знакомства');
            $table->foreignId('fs')->constrained('properties')->nullable()->comment('Семейное положение');
            $table->foreignId('children')->constrained('properties')->nullable();
            $table->foreignId('smoking')->constrained('properties')->nullable();
            $table->foreignId('alcohol')->constrained('properties')->nullable();
            $table->foreignId('education')->constrained('properties')->nullable();

            $table->foreignId('sign')->constrained('properties')->nullable();
            $table->integer('height')->nullable();
            $table->json('tags')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_properties');
    }
};
