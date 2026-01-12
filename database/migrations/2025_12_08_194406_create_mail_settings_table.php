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
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('password');
            $table->string('from_address');
            $table->string('from_name')->default('PIVITMor');
            $table->string('host');
            $table->integer('port')->default(587);
            $table->string('trust')->nullable();
            $table->string('protocol')->default('smtp');
            $table->string('encoding')->default('utf-8');
            $table->boolean('debug')->default(false);
            $table->boolean('auth_enabled')->default(true);
            $table->string('encryption')->default('tls');
            $table->boolean('starttls_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};
