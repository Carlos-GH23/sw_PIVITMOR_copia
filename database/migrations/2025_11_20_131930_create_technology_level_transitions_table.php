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
        Schema::create('technology_level_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_evaluation_id')->constrained()->cascadeOnDelete();

            $table->foreignId('initial_id')->constrained('technology_levels')->cascadeOnDelete();
            $table->foreignId('final_id')->constrained('technology_levels')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technology_level_transitions');
    }
};
