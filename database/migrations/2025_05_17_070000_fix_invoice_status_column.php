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
        // First, ensure the status column is a string
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('status', 20)->change();
        });

        // Update any remaining old status values to the new format
        DB::table('invoices')->whereIn('status', ['deposit', 'paid', 'processing', 'completed', 'cancelled'])->update(['status' => 'pending']);
        DB::table('invoices')->whereNull('status')->update(['status' => 'pending']);

        // Ensure all status values are lowercase
        DB::statement("UPDATE invoices SET status = LOWER(status)");

        // Validate and fix any invalid status values
        DB::table('invoices')
            ->whereNotIn('status', ['pending', 'recheck', 'done', 'cancel'])
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse these changes as they are data fixes
    }
};
