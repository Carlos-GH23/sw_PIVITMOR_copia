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
        Schema::create('conference_economic_sector', function (Blueprint $table) {
            $table->foreignId('conference_id')->constrained()->cascadeOnDelete();
            $table->foreignId('economic_sector_id')->constrained()->cascadeOnDelete();
            $table->primary(['conference_id', 'economic_sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_economic_sector');
    }
};
