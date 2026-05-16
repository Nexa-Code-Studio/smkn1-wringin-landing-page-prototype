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
        Schema::create('home_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge_text', 191)->nullable();
            $table->boolean('is_badge_visible')->default(true);

            $table->unsignedInteger('total_ekskul')->default(0);
            $table->unsignedInteger('siswa_aktif')->default(0);
            $table->unsignedInteger('total_prestasi')->default(0);
            $table->string('mitra_industri', 50)->default('0+');
            $table->unsignedTinyInteger('persen_melanjutkan_kuliah')->default(0);
            $table->unsignedTinyInteger('persen_bekerja_berwirausaha')->default(0);

            $table->unsignedBigInteger('cache_version')->default(1);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('is_badge_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_settings');
    }
};
