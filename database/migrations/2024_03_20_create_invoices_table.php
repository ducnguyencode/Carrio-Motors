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
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->decimal('total_price', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('final_price', 15, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card']);
            $table->enum('status', ['deposit', 'paid', 'processing', 'completed', 'cancelled'])->default('deposit');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
