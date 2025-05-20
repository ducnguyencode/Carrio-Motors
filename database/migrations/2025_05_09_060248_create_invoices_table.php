<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 20);
            $table->text('customer_address');
            $table->dateTime('purchase_date');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card'])->default('cash');
            $table->enum('status', ['deposit', 'paid', 'processing', 'completed', 'cancelled'])->default('deposit');
            $table->boolean('isActive')->default(true);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
