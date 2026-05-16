<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_assets', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 100)->index();
            $table->string('asset_type', 20)->index();
            $table->string('disk', 50)->default('public');
            $table->string('original_name', 191);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('original_path')->nullable();
            $table->string('jpeg_path')->nullable();
            $table->string('webp_path')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['page_key', 'asset_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_assets');
    }
};
