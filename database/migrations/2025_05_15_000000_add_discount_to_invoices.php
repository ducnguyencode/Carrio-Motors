<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->default(0)->after('purchase_date');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('subtotal');
            $table->string('discount_type')->nullable()->after('discount_amount'); // percentage or fixed
            $table->string('discount_reason')->nullable()->after('discount_type');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'discount_amount', 'discount_type', 'discount_reason']);
        });
    }
}
