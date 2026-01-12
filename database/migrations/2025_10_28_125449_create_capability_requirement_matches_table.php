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
        Schema::create('capability_requirement_matches', function (Blueprint $table) {
            $table->id();
            $table->decimal('compatibility_score', 5, 2)->default(0);
            $table->string('matching_algorithm')->default('auto');
            $table->boolean('is_active')->default(true);

            $table->foreignId('requirement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('capability_id')->constrained()->cascadeOnDelete();
            $table->foreignId('match_status_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capability_requirement_matches');
    }
};
