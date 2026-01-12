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
        Schema::create('ciees_accreditation_programs', function (Blueprint $table) {
            $table->id();
            $table->string('expiry_date');
            $table->integer('level');
            $table->foreignId('ciees_accreditation_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_offering_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciees_accreditation_programs');
    }
};
