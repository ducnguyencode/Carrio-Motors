<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('cars', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false);
            $table->date('date_manufactured')->nullable();
            $table->string('main_image')->nullable();
            $table->text('additional_images')->nullable();
            $table->dropColumn('brand');

            // Rename seats to seat_number and change constraints
            $table->dropColumn('seats');
            $table->integer('seat_number')->after('engine_id')->check('seat_number IN (2,4,5,7,9)');

            // Rename status to isActive
            $table->renameColumn('status', 'isActive');

            // Add description column
            $table->text('description')->nullable();
        });
    }

    public function down() {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('is_featured');
            $table->dropColumn('date_manufactured');
            $table->dropColumn('main_image');
            $table->dropColumn('additional_images');
            $table->string('brand');

            // Revert seat_number to seats
            $table->dropColumn('seat_number');
            $table->integer('seats')->check('seats IN (5,7)');

            // Revert isActive to status
            $table->renameColumn('isActive', 'status');

            // Remove description
            $table->dropColumn('description');
        });
    }
};
