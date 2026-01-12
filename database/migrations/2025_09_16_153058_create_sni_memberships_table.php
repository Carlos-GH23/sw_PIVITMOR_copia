<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sni_memberships', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('number')->nullable();
            $table->foreignId('academic_id')->constrained()->onDelete('cascade');
            $table->foreignId('research_area_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('sni_level_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sni_memberships');
    }
};
