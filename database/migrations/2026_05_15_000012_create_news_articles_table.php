<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('news_categories')->nullOnDelete();
            $table->string('title', 191);
            $table->string('slug', 220)->unique();
            $table->text('excerpt')->nullable();
            $table->string('author_name', 120)->nullable();
            $table->foreignId('cover_asset_id')->nullable()->constrained('page_assets')->nullOnDelete();
            $table->string('cover_alt_text', 255)->nullable();
            $table->string('workflow_status', 30)->default('draft')->index();
            $table->string('source_type', 30)->default('admin')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_note')->nullable();
            $table->string('submitter_name', 120)->nullable();
            $table->string('submitter_class', 80)->nullable();
            $table->string('submitter_contact', 120)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['workflow_status', 'published_at']);
            $table->index(['category_id', 'workflow_status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
