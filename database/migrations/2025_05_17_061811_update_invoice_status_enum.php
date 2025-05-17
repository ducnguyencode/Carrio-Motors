<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify any existing records to match new enum values
        DB::statement("UPDATE invoices SET status = 'pending' WHERE status = 'deposit'");
        DB::statement("UPDATE invoices SET status = 'recheck' WHERE status IN ('paid', 'processing')");
        DB::statement("UPDATE invoices SET status = 'done' WHERE status = 'completed'");
        DB::statement("UPDATE invoices SET status = 'cancel' WHERE status = 'cancelled'");

        // Then modify the column
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('pending', 'recheck', 'done', 'cancel') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, modify any existing records back to original values
        DB::statement("UPDATE invoices SET status = 'deposit' WHERE status = 'pending'");
        DB::statement("UPDATE invoices SET status = 'processing' WHERE status = 'recheck'");
        DB::statement("UPDATE invoices SET status = 'completed' WHERE status = 'done'");
        DB::statement("UPDATE invoices SET status = 'cancelled' WHERE status = 'cancel'");

        // Then restore the original column definition
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('deposit', 'paid', 'processing', 'completed', 'cancelled') DEFAULT 'deposit'");
    }
};
