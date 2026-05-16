<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_article_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_article_id')->constrained('news_articles')->cascadeOnDelete();
            $table->string('tag_name', 80);
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->index(['news_article_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_article_tags');
    }
};
