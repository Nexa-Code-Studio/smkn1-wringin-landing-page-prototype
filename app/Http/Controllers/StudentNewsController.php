<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderNewsBlockRequest;
use App\Http\Requests\StoreNewsBlockRequest;
use App\Http\Requests\StoreStudentNewsArticleRequest;
use App\Http\Requests\UpdateNewsBlockRequest;
use App\Http\Requests\UpdateStudentNewsArticleRequest;
use App\Models\NewsArticle;
use App\Models\NewsArticleBlock;
use App\Models\Siswa;
use App\Services\NewsBuilderService;
use App\Services\NewsContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentNewsController extends Controller
{
    public function index(NewsContentService $newsContentService): View
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();

        $articles = NewsArticle::query()
            ->with(['coverAsset', 'submittedBy'])
            ->where('submitted_by_type', Siswa::class)
            ->where('submitted_by_id', $siswa->id)
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (NewsArticle $article) => $newsContentService->resolveArticleSummary($article));

        return view('student.news_index', [
            'siswa' => $siswa,
            'articles' => $articles,
        ]);
    }

    public function create(NewsContentService $newsContentService): View
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();

        return $this->editorView(new NewsArticle([
            'workflow_status' => 'pending_review',
            'source_type' => 'student',
            'author_name' => $siswa->nama,
        ]), $newsContentService, false, $siswa);
    }

    public function store(StoreStudentNewsArticleRequest $request, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $payload = array_merge($request->validated(), [
            'author_name' => $siswa->nama,
        ]);

        $article = $newsBuilderService->saveArticle(
            null,
            $payload,
            $request->file('cover_file'),
            null,
            $siswa,
            'pending_review',
        );

        return redirect()
            ->route('siswa.berita.edit', $article)
            ->with('success', 'Berita berhasil disimpan dan dikirim untuk review.');
    }

    public function edit(NewsArticle $article, NewsContentService $newsContentService): View
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        if ($resolvedArticle->workflow_status === 'published') {
            return redirect()
                ->route('siswa.berita.index')
                ->withErrors(['article' => 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.']);
        }

        $resolvedArticle->load(['coverAsset', 'tags', 'allBlocks.media.asset', 'submittedBy']);

        return $this->editorView($resolvedArticle, $newsContentService, true, $siswa);
    }

    public function update(UpdateStudentNewsArticleRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.');

        $payload = array_merge($request->validated(), [
            'author_name' => $siswa->nama,
        ]);

        $newsBuilderService->saveArticle(
            $resolvedArticle,
            $payload,
            $request->file('cover_file'),
            null,
            null,
            'pending_review',
        );

        return back()->with('success', 'Perubahan berita berhasil disimpan dan dikirim ulang untuk review.');
    }

    public function destroy(NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat dihapus oleh siswa.');

        $newsBuilderService->deleteArticle($resolvedArticle);

        return redirect()->route('siswa.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function storeBlock(StoreNewsBlockRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.');

        $validated = $request->validated();
        $newsBuilderService->createBlock(
            $resolvedArticle,
            $validated['block_type'],
            $validated,
            $request->file('asset_file'),
            $request->file('asset_files', []),
            null,
        );

        return back()->with('success', 'Komponen berita berhasil ditambahkan.');
    }

    public function updateBlock(UpdateNewsBlockRequest $request, NewsArticle $article, int $block, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.');

        $resolvedBlock = $this->resolveOwnedBlock($resolvedArticle, $block);
        if (! $resolvedBlock) {
            return redirect()->route('siswa.berita.edit', $resolvedArticle)->withErrors(['block' => 'Komponen berita tidak ditemukan.']);
        }

        $newsBuilderService->updateBlock(
            $resolvedBlock,
            $request->validated(),
            $request->file('asset_file'),
            $request->file('asset_files', []),
            null,
        );

        return back()->with('success', 'Komponen berita berhasil diperbarui.');
    }

    public function destroyBlock(NewsArticle $article, int $block, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.');

        $resolvedBlock = $this->resolveOwnedBlock($resolvedArticle, $block);
        if (! $resolvedBlock) {
            return redirect()->route('siswa.berita.edit', $resolvedArticle)->withErrors(['block' => 'Komponen berita tidak ditemukan.']);
        }

        $newsBuilderService->deleteBlock($resolvedBlock, null);

        return back()->with('success', 'Komponen berita berhasil dihapus.');
    }

    public function reorderBlocks(ReorderNewsBlockRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): JsonResponse|RedirectResponse
    {
        /** @var Siswa $siswa */
        $siswa = auth('siswa')->user();
        $resolvedArticle = $this->resolveOwnedArticle($article, $siswa);

        abort_if($resolvedArticle->workflow_status === 'published', 403, 'Berita yang sudah dipublish tidak dapat diedit oleh siswa.');

        $newsBuilderService->reorderBlocks($resolvedArticle, $request->validated()['block_ids'], null);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Urutan komponen berita berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Urutan komponen berita berhasil diperbarui.');
    }

    private function editorView(NewsArticle $article, NewsContentService $newsContentService, bool $articleExists, Siswa $siswa): View
    {
        $builderReady = $newsContentService->tablesReady();
        $article->loadMissing(['coverAsset', 'tags', 'allBlocks.media.asset', 'submittedBy']);
        $resolvedArticle = $articleExists ? $newsContentService->resolveArticle($article) : null;

        return view('graduation.news_editor', [
            'builderReady' => $builderReady,
            'article' => $article,
            'articleExists' => $articleExists,
            'categories' => $builderReady ? $newsContentService->categories() : collect(),
            'resolvedArticle' => $resolvedArticle,
            'blocks' => $articleExists ? $newsContentService->resolvedBlocks($article) : [],
            'tagsText' => $articleExists ? $article->tags->pluck('tag_name')->implode("\n") : '',
            'editorSubmitter' => $resolvedArticle['submitter'] ?? [
                'role' => 'Siswa',
                'name' => trim((string) $siswa->nama) ?: 'Siswa',
                'identifier' => trim((string) $siswa->nisn) ?: '-',
                'is_resolved' => true,
            ],
            'portalMode' => 'student',
        ]);
    }

    private function resolveOwnedArticle(NewsArticle $article, Siswa $siswa): NewsArticle
    {
        abort_unless(
            $article->submitted_by_type === Siswa::class
            && (int) $article->submitted_by_id === (int) $siswa->id,
            404
        );

        return $article;
    }

    private function resolveOwnedBlock(NewsArticle $article, int $blockId): ?NewsArticleBlock
    {
        $block = NewsArticleBlock::query()->find($blockId);

        if (! $block || $block->news_article_id !== $article->id) {
            return null;
        }

        return $block;
    }
}
