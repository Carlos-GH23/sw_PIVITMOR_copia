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
        Schema::create('consent_configurations', function (Blueprint $table) {
            $table->id();
             $table->boolean('data_usage_consent');
            $table->boolean('force_acceptance');
            $table->boolean('electronic_communication_consent');
            $table->text('electronic_communication_message')->nullable();
            $table->boolean('statistical_data_consent');
            $table->text('statistical_data_message')->nullable();
            $table->enum('frequency_of_acceptance', ['never', 'bi_annually', 'annually', 'version_change']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consent_configurations');
    }
};
