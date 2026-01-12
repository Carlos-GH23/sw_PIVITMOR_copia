<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_offering_oecd_sector', function (Blueprint $table) {
            $table->foreignId('academic_offering_id')->constrained('academic_offerings')->onDelete('cascade');
            $table->foreignId('oecd_sector_id')->constrained('oecd_sectors')->onDelete('cascade');
            $table->primary(['academic_offering_id', 'oecd_sector_id'], 'academic_offering_oecd_sector_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_offering_oecd_sector');
    }
};
