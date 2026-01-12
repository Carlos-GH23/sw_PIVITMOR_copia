<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('academic_oecd_sector', function (Blueprint $table) {
            $table->foreignId('academic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('oecd_sector_id')->constrained()->cascadeOnDelete();
            $table->primary(['academic_id', 'oecd_sector_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_oecd_sector');
    }
};
