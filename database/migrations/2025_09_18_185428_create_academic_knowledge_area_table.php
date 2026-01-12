<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('academic_knowledge_area', function (Blueprint $table) {
            $table->foreignId('academic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('knowledge_area_id')->constrained()->cascadeOnDelete();
            $table->primary(['academic_id', 'knowledge_area_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_knowledge_area');
    }
};
