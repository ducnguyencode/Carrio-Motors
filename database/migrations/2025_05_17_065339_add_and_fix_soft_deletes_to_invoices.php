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
        // Đầu tiên, xóa cột deleted_at nếu nó đã tồn tại
        if (Schema::hasColumn('invoices', 'deleted_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }

        // Thêm lại cột deleted_at với cấu hình đúng
        Schema::table('invoices', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Cập nhật các status không hợp lệ
        DB::table('invoices')
            ->whereIn('status', ['deposit', 'paid', 'processing', 'completed', 'cancelled'])
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
