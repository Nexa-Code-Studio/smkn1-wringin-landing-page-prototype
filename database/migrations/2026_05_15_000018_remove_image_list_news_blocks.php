<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('news_article_blocks')
            ->where('block_type', 'image_list')
            ->delete();
    }

    public function down(): void
    {
    }
};
