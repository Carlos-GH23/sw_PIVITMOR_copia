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
        Schema::create('oecd_sector_technology_service', function (Blueprint $table) {
            $table->foreignId('oecd_sector_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_service_id')->constrained()->cascadeOnDelete();
            $table->primary(['oecd_sector_id', 'technology_service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oecd_sector_technology_service');
    }
};
