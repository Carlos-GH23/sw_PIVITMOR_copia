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
        Schema::create('impact_metric_match_evaluation', function (Blueprint $table) {
            $table->foreignId('match_evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('impact_metric_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_metric_match_evaluation');
    }
};
