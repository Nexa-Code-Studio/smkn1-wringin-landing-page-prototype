<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_article_block_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_article_block_id')->constrained('news_article_blocks')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('page_assets')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(1);
            $table->string('caption', 255)->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['news_article_block_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_article_block_media');
    }
};
