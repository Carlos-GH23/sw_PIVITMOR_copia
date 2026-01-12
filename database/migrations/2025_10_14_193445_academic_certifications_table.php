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
        Schema::create('academic_certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('certification_level_id')->constrained('certification_levels')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('certifying_entity');
            $table->foreignId('accreditation_entity_id')->constrained('accreditation_entities')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->foreignId('status_id')->constrained('academic_certification_statuses')->onDelete('cascade');
            $table->integer('validity_duration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('academic_id')->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_certifications');
    }
};
