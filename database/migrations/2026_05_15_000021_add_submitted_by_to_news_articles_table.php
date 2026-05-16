<?php

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('submitted_by_type')->nullable()->after('source_type');
            $table->unsignedBigInteger('submitted_by_id')->nullable()->after('submitted_by_type');
            $table->index(['submitted_by_type', 'submitted_by_id']);
        });

        DB::table('news_articles')
            ->whereNotNull('created_by')
            ->update([
                'submitted_by_type' => User::class,
                'submitted_by_id' => DB::raw('created_by'),
            ]);

        $studentArticles = DB::table('news_articles')
            ->where('source_type', 'student')
            ->whereNull('submitted_by_id')
            ->get(['id', 'submitter_name', 'submitter_class']);

        foreach ($studentArticles as $article) {
            $name = trim((string) ($article->submitter_name ?? ''));
            $class = trim((string) ($article->submitter_class ?? ''));

            if ($name === '') {
                continue;
            }

            $query = DB::table('siswas')
                ->whereRaw('LOWER(TRIM(nama)) = ?', [mb_strtolower($name)]);

            if ($class !== '') {
                $query->whereRaw('LOWER(TRIM(kelas)) = ?', [mb_strtolower($class)]);
            }

            $match = $query->get(['id']);

            if ($match->count() !== 1) {
                continue;
            }

            $siswaId = (int) $match->first()->id;

            DB::table('news_articles')
                ->where('id', $article->id)
                ->update([
                    'submitted_by_type' => Siswa::class,
                    'submitted_by_id' => $siswaId,
                ]);

            DB::table('siswas')
                ->where('id', $siswaId)
                ->update(['can_submit_news' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex(['submitted_by_type', 'submitted_by_id']);
            $table->dropColumn(['submitted_by_type', 'submitted_by_id']);
        });
    }
};
