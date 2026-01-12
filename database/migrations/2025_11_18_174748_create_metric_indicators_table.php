<?php

use App\Enums\MetricIndicatorType;
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
        Schema::create('metric_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', MetricIndicatorType::values());
            $table->morphs('indicatorable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metric_indicators');
    }
};
