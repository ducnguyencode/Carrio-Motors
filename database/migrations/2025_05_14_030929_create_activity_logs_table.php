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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_role')->nullable();
            $table->string('user_name')->nullable();
            $table->string('action'); // 'create', 'update', 'delete', 'login', 'logout', etc.
            $table->string('module'); // Which module was affected (users, cars, models, etc.)
            $table->string('reference_id')->nullable(); // ID of the affected record
            $table->text('details')->nullable(); // JSON details of the changes
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
