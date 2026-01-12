<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_offerings', function (Blueprint $table) { 
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('objective')->nullable();
            $table->text('graduate_profile')->nullable();
            $table->string('website')->nullable();
            $table->decimal('semester_cost', 8, 2)->nullable();
            $table->unsignedSmallInteger('duration_months')->nullable();
            $table->string('revoe')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreignId('educational_level_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('study_mode_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('fimpes_accreditation_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
       Schema::dropIfExists('academic_offerings');
    }
};
