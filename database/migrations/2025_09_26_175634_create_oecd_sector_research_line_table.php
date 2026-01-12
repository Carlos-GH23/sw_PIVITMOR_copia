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
        Schema::create('oecd_sector_research_line', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oecd_sector_id')->constrained()->cascadeOnDelete();
            $table->foreignId('research_line_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oecd_sector_research_line');
    }
};
