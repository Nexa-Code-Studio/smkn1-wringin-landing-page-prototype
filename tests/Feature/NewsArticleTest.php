<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_article_has_category_relationship(): void
    {
        $category = new NewsCategory();
        $category->name = 'Teknologi';
        $category->slug = 'teknologi';
        $category->save();

        $article = new NewsArticle();
        $article->title = 'Test Article';
        $article->slug = 'test-article';
        $article->category_id = $category->id;
        $article->save();

        $this->assertInstanceOf(NewsCategory::class, $article->category);
        $this->assertEquals('Teknologi', $article->category->name);
    }
}
