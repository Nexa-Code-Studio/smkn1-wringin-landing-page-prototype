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
        Schema::create('page_images', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 100)->index();
            $table->string('slot_key', 150);
            $table->string('section', 150)->nullable();
            $table->string('title', 191);
            $table->string('alt_text', 255)->nullable();

            $table->string('disk', 50)->default('public');

            $table->string('jpeg_path')->nullable();
            $table->string('webp_path')->nullable();

            $table->unsignedInteger('jpeg_width')->nullable();
            $table->unsignedInteger('jpeg_height')->nullable();
            $table->unsignedBigInteger('jpeg_bytes')->nullable();
            $table->unsignedTinyInteger('jpeg_quality')->nullable();

            $table->unsignedInteger('webp_width')->nullable();
            $table->unsignedInteger('webp_height')->nullable();
            $table->unsignedBigInteger('webp_bytes')->nullable();
            $table->unsignedTinyInteger('webp_quality')->nullable();

            $table->boolean('is_active')->default(true)->index();
            $table->unsignedBigInteger('cache_version')->default(1);
            $table->timestamp('last_generated_at')->nullable();

            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->unique(['page_key', 'slot_key']);
            $table->index(['page_key', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_images');
    }
};
