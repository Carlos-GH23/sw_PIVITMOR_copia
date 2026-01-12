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
        Schema::create('institution_certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 2000);
            $table->foreignId('certification_type_id')->nullable()->constrained('certification_types')->onDelete('cascade');
            $table->string('certifying_entity')->nullable();
            $table->unsignedBigInteger('certified_resource_id')->nullable();
            $table->string('certified_resource_type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('resource_type_id')
                ->nullable()
                ->constrained('resource_types')
                ->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_certifications');
    }
};
