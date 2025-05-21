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
        Schema::table('cars', function (Blueprint $table) {
            $table->string('horsepower')->nullable()->after('rating');
            $table->string('torque')->nullable()->after('horsepower');
            $table->string('acceleration')->nullable()->after('torque');
            $table->string('fuel_consumption')->nullable()->after('acceleration');
            $table->string('length')->nullable()->after('fuel_consumption');
            $table->string('width')->nullable()->after('length');
            $table->string('height')->nullable()->after('width');
            $table->string('cargo_volume')->nullable()->after('height');
            $table->string('fuel_capacity')->nullable()->after('cargo_volume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'horsepower',
                'torque',
                'acceleration',
                'fuel_consumption',
                'length',
                'width',
                'height',
                'cargo_volume',
                'fuel_capacity'
            ]);
        });
    }
};
