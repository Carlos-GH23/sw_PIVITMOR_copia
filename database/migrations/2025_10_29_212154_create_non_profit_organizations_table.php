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
        Schema::create('non_profit_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('mission')->nullable();
            $table->text('main_projects')->nullable();
            $table->string('cluni')->nullable();
            $table->string('rfc')->nullable();
            $table->string('legal_representative')->nullable();
            $table->foreignId('economic_sector_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('legal_entity_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('market_reach_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('non_profit_organizations');
    }
};
