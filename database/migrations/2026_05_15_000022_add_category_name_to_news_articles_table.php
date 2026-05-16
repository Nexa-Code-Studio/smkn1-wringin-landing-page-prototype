<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('category_name', 100)->nullable()->after('category_id');
            $table->index(['category_name', 'workflow_status', 'published_at'], 'news_articles_category_name_workflow_published_idx');
        });

        $categoryMap = DB::table('news_categories')->pluck('name', 'id');

        DB::table('news_articles')
            ->whereNull('category_name')
            ->get(['id', 'category_id'])
            ->each(function ($article) use ($categoryMap) {
                $categoryName = $categoryMap[$article->category_id] ?? null;

                if (! $categoryName) {
                    return;
                }

                DB::table('news_articles')
                    ->where('id', $article->id)
                    ->update(['category_name' => $categoryName]);
            });
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex('news_articles_category_name_workflow_published_idx');
            $table->dropColumn('category_name');
        });
    }
};
