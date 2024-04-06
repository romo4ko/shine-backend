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
        Schema::create('user_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->text('text')->nullable();
            $table->date('birthdate')->nullable();
            $table->foreignId('sex')->nullable()->constrained('properties');
            $table->foreignId('city')->nullable()->constrained('cities');

            $table->foreignId('purpose')->nullable()->constrained('properties')->comment('Цель знакомства');
            $table->foreignId('fs')->nullable()->constrained('properties')->comment('Семейное положение');
            $table->foreignId('children')->nullable()->constrained('properties');
            $table->foreignId('smoking')->nullable()->constrained('properties');
            $table->foreignId('alcohol')->nullable()->constrained('properties');
            $table->foreignId('education')->nullable()->constrained('properties');

            $table->foreignId('sign')->nullable()->constrained('properties');
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
