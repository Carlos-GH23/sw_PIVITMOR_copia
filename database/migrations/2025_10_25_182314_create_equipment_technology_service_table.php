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
        Schema::create('equipment_technology_service', function (Blueprint $table) {
            $table->foreignId('equipment_id')->constrained('facility_equipments')->cascadeOnDelete();
            $table->foreignId('technology_service_id')->constrained()->cascadeOnDelete();
            $table->primary(['equipment_id', 'technology_service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('equipment_technology_service');
    }
};
