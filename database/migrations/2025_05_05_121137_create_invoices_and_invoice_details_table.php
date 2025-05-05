<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone', 50);
            $table->string('customer_email')->nullable();
            $table->timestamp('purchase_date')->useCurrent();
            $table->decimal('total_price', 15, 2);
            $table->string('payment_method', 100);
            $table->string('process', 50)->default('đặt cọc');
            $table->boolean('isActive')->default(true);

            $table->timestamps();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')
                  ->references('id')->on('invoices')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('car_detail_id');
            $table->foreign('car_detail_id')
                  ->references('id')->on('car_details')
                  ->onDelete('restrict');

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 15, 2);

            $table->boolean('isActive')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('invoices');
    }
};
