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
        Schema::create('match_evaluation_category', function (Blueprint $table) {
            $table->foreignId('match_evaluation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('match_evaluation_category_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_evaluation_category');
    }
};
