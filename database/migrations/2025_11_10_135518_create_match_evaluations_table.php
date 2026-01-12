<?php

use App\Enums\TerritoryLevel;
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
        Schema::create('match_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('story')->nullable();
            $table->text('results')->nullable();
            $table->text('goals')->nullable();
            $table->text('lessons')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->integer('training_hours')->nullable();
            $table->decimal('economic_estimate', 12, 2)->nullable();
            $table->decimal('productivity_increase', 5, 2)->nullable();
            $table->enum('territorial_level', TerritoryLevel::values())->nullable();
            $table->string('emissions_percentage')->nullable();
            $table->string('emissions_methodology')->nullable();
            $table->string('community_impact_level')->nullable();
            $table->string('inclusion_equity_level')->nullable();
            $table->string('project_sustainability_status')->nullable();
            $table->decimal('continuity_percentage', 5, 2)->nullable();
            $table->string('continuity_type')->nullable();
            $table->decimal('communication_management_percentage', 5, 2)->nullable();
            $table->string('infrastructure_level')->nullable();
            $table->decimal('estimated_investment', 12, 2)->nullable();
            $table->integer('maturity_level')->nullable();
            $table->string('structure_type')->nullable();
            $table->decimal('public_service_percentage', 5, 2)->nullable();
            $table->string('transparency_level')->nullable();
            $table->decimal('process_digitalization_percentage', 5, 2)->nullable();
            $table->decimal('process_simplification_percentage', 5, 2)->nullable();
            $table->string('interoperability_level')->nullable();
            $table->timestamp('evaluated_at')->nullable();

            $table->boolean('is_success_story')->default(false);
            $table->foreignId('capability_requirement_match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('match_evaluation_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_evaluations');
    }
};
