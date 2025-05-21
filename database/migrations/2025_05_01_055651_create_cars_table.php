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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->foreignId('model_id')->constrained('models')->onDelete('cascade');
            $table->foreignId('engine_id')->constrained('engines')->onDelete('cascade');
            $table->enum('transmission',['manual','automatic']);
            $table->integer('seats')->check('seats IN (5,7)');
            $table->boolean('status')->default(true);
            $table->integer('reviews_count')->default(0);
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
