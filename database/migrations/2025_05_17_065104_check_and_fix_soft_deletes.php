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
        if (Schema::hasColumn('invoices', 'deleted_at')) {
            // Nếu cột đã tồn tại, chúng ta sẽ đảm bảo nó có định dạng đúng
            Schema::table('invoices', function (Blueprint $table) {
                $table->timestamp('deleted_at')->nullable()->change();
            });
        } else {
            // Nếu cột chưa tồn tại, thêm mới
            Schema::table('invoices', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
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
