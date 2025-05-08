<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('car_colors')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars_details');
    }
};
