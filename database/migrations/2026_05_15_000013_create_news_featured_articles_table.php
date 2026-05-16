<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_featured_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('slot_order')->unique();
            $table->foreignId('news_article_id')->unique()->constrained('news_articles')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_featured_articles');
    }
};
