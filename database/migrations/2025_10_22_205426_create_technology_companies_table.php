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
        Schema::create('technology_companies', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->integer('num_employees');
            $table->foreignId('origen_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_size_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('innovation_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technology_level_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('market_reach_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technology_companies');
    }
};
