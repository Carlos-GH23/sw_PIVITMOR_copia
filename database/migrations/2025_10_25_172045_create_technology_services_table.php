Pero <?php

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
        Schema::create('technology_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('technical_description', 2000)->nullable();
            $table->foreignId('technology_service_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technology_service_category_id')->nullable()->constrained()->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technology_service_status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technology_services');
    }
};
