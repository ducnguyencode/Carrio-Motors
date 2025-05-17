<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_details', 'car_id')) {
                $table->dropForeign(['car_id']);
                $table->dropColumn('car_id');
            }

            if (!Schema::hasColumn('invoice_details', 'car_detail_id')) {
                $table->foreignId('car_detail_id')->after('invoice_id')->constrained('cars_details')->onDelete('restrict');
            }
        });
    }

    public function down()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_details', 'car_detail_id')) {
                $table->dropForeign(['car_detail_id']);
                $table->dropColumn('car_detail_id');
            }

            if (!Schema::hasColumn('invoice_details', 'car_id')) {
                $table->foreignId('car_id')->after('invoice_id')->constrained()->onDelete('restrict');
            }
        });
    }
};
