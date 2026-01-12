<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('knowledge_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('knowledge_lineable_id');
            $table->string('knowledge_lineable_type');
            $table->index(['knowledge_lineable_type', 'knowledge_lineable_id'], 'knowledge_lines_poly_index');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_lines');
    }
};