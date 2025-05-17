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
        // Đầu tiên, thay đổi cột status để chấp nhận các giá trị dài hơn
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('status', 20)->change();
        });

        // Cập nhật các status cũ sang status mới
        DB::table('invoices')->where('status', 'deposit')->update(['status' => 'pending']);
        DB::table('invoices')->where('status', 'paid')->update(['status' => 'done']);
        DB::table('invoices')->where('status', 'processing')->update(['status' => 'pending']);
        DB::table('invoices')->where('status', 'completed')->update(['status' => 'done']);
        DB::table('invoices')->where('status', 'cancelled')->update(['status' => 'cancel']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không cần rollback vì chúng ta không muốn đảo ngược việc cập nhật status
    }
};
