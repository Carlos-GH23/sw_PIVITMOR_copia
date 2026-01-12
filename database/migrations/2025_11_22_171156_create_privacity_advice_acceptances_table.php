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
        Schema::create('privacity_advice_acceptances', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_accepted');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('privacity_compliance_id')->nullable()->constrained('privacity_compliances')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacity_advice_acceptances');
    }
};
