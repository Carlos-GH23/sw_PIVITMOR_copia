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
        Schema::create('organization_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organization_type');
            $table->string('organization_sector');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('municipality_id')->nullable()->constrained('municipalities')->onDelete('set null');
            $table->string('email');
            $table->foreignId('organization_registration_status_id')
                ->default(1)
                ->constrained('organization_registration_statuses', 'id', 'org_reg_status_fk')
                ->onDelete('cascade');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_registrations');
    }
};
