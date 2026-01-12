<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('module_key', 50)->nullable()->after('event');
            $table->string('role_name', 100)->nullable()->after('module_key');
            $table->unsignedBigInteger('role_id')->nullable()->after('role_name');
            $table->unsignedInteger('duration_seconds')->nullable()->after('role_id');
            $table->timestamp('last_heartbeat_at')->nullable()->after('duration_seconds');

            $table->index('module_key');
            $table->index('role_name');
            $table->index('role_id');
            $table->index(['log_name', 'created_at']);
            $table->index(['log_name', 'module_key', 'created_at']);
            $table->index(['log_name', 'role_name', 'created_at']);
            $table->index(['causer_id', 'created_at']);

            $table->index(['module_key', 'duration_seconds'], 'activity_log_module_duration_index');
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex('activity_log_module_duration_index');

            $table->dropIndex(['log_name', 'created_at']);
            $table->dropIndex(['log_name', 'module_key', 'created_at']);
            $table->dropIndex(['log_name', 'role_name', 'created_at']);
            $table->dropIndex(['causer_id', 'created_at']);
            $table->dropIndex(['module_key']);
            $table->dropIndex(['role_name']);
            $table->dropIndex(['role_id']);

            $table->dropColumn([
                'module_key',
                'role_name',
                'role_id',
                'duration_seconds',
                'last_heartbeat_at'
            ]);
        });
    }
};
