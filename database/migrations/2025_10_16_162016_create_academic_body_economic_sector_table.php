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
        Schema::create('academic_body_economic_sector', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_body_id')->constrained()->cascadeOnDelete();
            $table->foreignId('economic_sector_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_body_economic_sector');
    }
};
