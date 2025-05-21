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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('seller_tax_code')->default('0981826971')->after('customer_address');
            $table->string('customer_tax_code')->nullable()->after('seller_tax_code');
            $table->decimal('tax_rate', 5, 2)->default(10.00)->after('customer_tax_code');
            $table->decimal('tax_amount', 15, 2)->default(0)->after('tax_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('seller_tax_code');
            $table->dropColumn('customer_tax_code');
            $table->dropColumn('tax_rate');
            $table->dropColumn('tax_amount');
        });
    }
};
