<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_images', function (Blueprint $table) {
            $table->index(['page_key', 'is_active'], 'idx_page_images_lookup');
            $table->index(['page_key', 'cache_version'], 'idx_page_images_version');
        });
    }

    public function down(): void
    {
        Schema::table('page_images', function (Blueprint $table) {
            $table->dropIndex('idx_page_images_lookup');
            $table->dropIndex('idx_page_images_version');
        });
    }
};
