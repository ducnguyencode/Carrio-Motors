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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('video_url')->nullable();
            $table->string('title')->nullable(); // For 'Car 1' text
            $table->string('subtitle')->nullable(); // For 'Luxury meets performance' text
            $table->text('main_content')->nullable(); // Optional now
            $table->foreignId('car_id')->nullable()->constrained('cars'); // Optional now
            $table->integer('position')->default(0); // For ordering banners
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
