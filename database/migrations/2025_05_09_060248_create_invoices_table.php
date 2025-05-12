<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name');
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone', 50)->nullable();
            $table->dateTime('purchase_date');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->enum('payment_method', ['cash', 'credit', 'installment'])->default('cash');
            $table->enum('process_status', ['deposit', 'payment', 'warehouse', 'success', 'cancel'])->default('deposit');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
