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
        Schema::create('academic_offering_economic_sector', function (Blueprint $table) {
            $table->foreignId('academic_offering_id')->constrained('academic_offerings')->onDelete('cascade');
            $table->foreignId('economic_sector_id')->constrained('economic_sectors')->onDelete('cascade');
            $table->primary(['academic_offering_id', 'economic_sector_id'], 'academic_offering_economic_sector_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_offering_economic_sector');
    }
};
