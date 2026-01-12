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
        Schema::create('capability_knowledge_area', function (Blueprint $table) {
            $table->foreignId('capability_id')->constrained()->cascadeOnDelete();
            $table->foreignId('knowledge_area_id')->constrained()->cascadeOnDelete();
            $table->primary(['capability_id', 'knowledge_area_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capability_knowledge_area');
    }
};
