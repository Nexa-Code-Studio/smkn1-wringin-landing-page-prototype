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
        Schema::create('home_featured_extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_page_setting_id')->constrained('home_page_settings')->cascadeOnDelete();
            $table->string('name', 100);
            $table->unsignedTinyInteger('sort_order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['home_page_setting_id', 'sort_order']);
            $table->index(['home_page_setting_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_featured_extracurriculars');
    }
};
