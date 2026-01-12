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
        Schema::create('facility_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('equipment_type_id')->nullable()
                ->constrained('equipment_types')
                ->nullOnDelete()
                ->restrictOnDelete();
            $table->foreignId('facility_id')->nullable()
                ->constrained('facilities')
                ->cascadeOnDelete()
                ->restrictOnDelete();
            $table->foreignId('responsible_id')->nullable()
                ->constrained('academics')
                ->nullOnDelete()
                ->restrictOnDelete();
            $table->boolean('status')->nullable()->default(true);
            $table->foreignId('department_id')->nullable()
                ->constrained('departments')
                ->nullOnDelete()
                ->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_equipments');
    }
};
