<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('oecd_sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('level')->nullable();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('oecd_sectors')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('economic_social_sector_id')->nullable()->constrained('economic_social_sectors')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['parent_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oecd_sectors');
    }
};
