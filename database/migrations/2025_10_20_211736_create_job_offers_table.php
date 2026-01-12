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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->enum('gender', ['Masculino', 'Femenino', 'Indistinto'])->default('Indistinto');
            $table->boolean('travel_requirements')->default(false)->nullable();
            $table->foreignId('job_offer_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('academic_degree_id')->nullable()->constrained()->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('job_description');
            $table->text('responsibilities');
            $table->text('skills_languages')->nullable();
            $table->text('observations')->nullable();
            $table->text('comments')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
