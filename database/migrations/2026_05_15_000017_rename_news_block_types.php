<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('news_article_blocks')
            ->where('block_type', 'gallery')
            ->update(['block_type' => 'image_list']);

        $showcaseBlocks = DB::table('news_article_blocks')
            ->where('block_type', 'image_with_subtext')
            ->get(['id', 'payload']);

        foreach ($showcaseBlocks as $block) {
            $payload = json_decode((string) ($block->payload ?? '[]'), true);
            $payload = is_array($payload) ? $payload : [];
            unset($payload['subtext']);

            DB::table('news_article_blocks')
                ->where('id', $block->id)
                ->update([
                    'block_type' => 'image_showcase',
                    'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
        }

        if ($showcaseBlocks->isNotEmpty()) {
            DB::table('news_article_block_media')
                ->whereIn('news_article_block_id', $showcaseBlocks->pluck('id')->all())
                ->update(['caption' => null]);
        }
    }

    public function down(): void
    {
        DB::table('news_article_blocks')
            ->where('block_type', 'image_list')
            ->update(['block_type' => 'gallery']);

        DB::table('news_article_blocks')
            ->where('block_type', 'image_showcase')
            ->update(['block_type' => 'image_with_subtext']);
    }
};
