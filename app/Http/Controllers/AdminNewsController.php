<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderNewsBlockRequest;
use App\Http\Requests\StoreNewsArticleRequest;
use App\Http\Requests\StoreNewsBlockRequest;
use App\Http\Requests\UpdateNewsArticleRequest;
use App\Http\Requests\UpdateNewsBlockRequest;
use App\Http\Requests\UpdateNewsFeaturedArticlesRequest;
use App\Models\NewsArticle;
use App\Models\NewsArticleBlock;
use App\Models\User;
use App\Services\NewsBuilderService;
use App\Services\NewsContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminNewsController extends Controller
{
    public function index(Request $request, NewsContentService $newsContentService): View
    {
        $builderReady = $newsContentService->tablesReady();
        $categories = $builderReady ? $newsContentService->categories() : collect();
        $featuredSlots = $builderReady ? $newsContentService->featuredSlots() : collect();
        $featuredOptions = $builderReady ? $newsContentService->featuredArticleOptions() : collect();

        $articles = $builderReady
            ? NewsArticle::query()
                ->with(['coverAsset', 'tags', 'submittedBy'])
                ->when($request->string('status')->toString(), fn ($query, $status) => $query->where('workflow_status', $status))
                ->when($request->string('category')->toString(), fn ($query, $category) => $query->where('category_name', $category))
                ->when($request->string('source')->toString(), fn ($query, $source) => $query->where('source_type', $source))
                ->when($request->string('q')->toString(), function ($query, $keyword) {
                    $query->where(function ($innerQuery) use ($keyword) {
                        $innerQuery->where('title', 'like', '%'.$keyword.'%')
                            ->orWhere('excerpt', 'like', '%'.$keyword.'%')
                            ->orWhere('author_name', 'like', '%'.$keyword.'%');
                    });
                })
                ->orderByRaw("case workflow_status when 'pending_review' then 0 when 'draft' then 1 when 'published' then 2 else 3 end")
                ->orderByDesc('published_at')
                ->orderByDesc('updated_at')
                ->paginate(12)
                ->withQueryString()
            : collect();

        $stats = $builderReady
            ? [
                'total' => NewsArticle::query()->count(),
                'published' => NewsArticle::query()->where('workflow_status', 'published')->count(),
                'pending_review' => NewsArticle::query()->where('workflow_status', 'pending_review')->count(),
                'draft' => NewsArticle::query()->where('workflow_status', 'draft')->count(),
                'rejected' => NewsArticle::query()->where('workflow_status', 'rejected')->count(),
            ]
            : [
                'total' => 0,
                'published' => 0,
                'pending_review' => 0,
                'draft' => 0,
                'rejected' => 0,
            ];

        return view('graduation.news_index', [
            'builderReady' => $builderReady,
            'categories' => $categories,
            'featuredSlots' => $featuredSlots,
            'featuredOptions' => $featuredOptions,
            'articles' => $articles,
            'stats' => $stats,
            'filters' => [
                'status' => $request->string('status')->toString(),
                'category' => $request->string('category')->toString(),
                'source' => $request->string('source')->toString(),
                'q' => $request->string('q')->toString(),
            ],
        ]);
    }

    public function create(NewsContentService $newsContentService): View
    {
        return $this->editorView(new NewsArticle([ 
            'workflow_status' => 'draft',
            'source_type' => 'admin',
            'author_name' => 'Tim Humas SMKN 1 Wringin',
        ]), $newsContentService, false);
    }

    public function store(StoreNewsArticleRequest $request, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $article = $newsBuilderService->saveArticle(
            null,
            $request->validated(),
            $request->file('cover_file'),
            Auth::id(),
            Auth::user(),
        );

        return redirect()
            ->route('admin.berita.edit', $article)
            ->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(NewsArticle $article, NewsContentService $newsContentService): View
    {
        $article->load(['coverAsset', 'tags', 'allBlocks.media.asset', 'submittedBy']);

        return $this->editorView($article, $newsContentService, true);
    }

    public function update(UpdateNewsArticleRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $article = $newsBuilderService->saveArticle(
            $article,
            $request->validated(),
            $request->file('cover_file'),
            Auth::id(),
        );

        return redirect()
            ->route('admin.berita.edit', $article)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $newsBuilderService->deleteArticle($article);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function updateFeatured(UpdateNewsFeaturedArticlesRequest $request, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $slots = collect($request->validated()['slots'])
            ->values()
            ->mapWithKeys(fn ($articleId, $index) => [$index + 1 => $articleId ? (int) $articleId : null])
            ->all();

        $selectedIds = collect($slots)->filter()->values();

        if ($selectedIds->count() !== $selectedIds->unique()->count()) {
            return back()->withErrors([
                'slots' => 'Satu berita hanya boleh dipakai pada satu slot highlight.',
            ])->withInput();
        }

        $publishedIds = NewsArticle::query()
            ->whereIn('id', $selectedIds)
            ->published()
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        foreach (collect($slots)->filter() as $articleId) {
            abort_unless(in_array((int) $articleId, $publishedIds, true), 422, 'Hanya berita published yang dapat di-highlight.');
        }

        $newsBuilderService->updateFeaturedArticles($slots, Auth::id());

        return back()->with('success', 'Slot highlight berita berhasil diperbarui.');
    }

    public function storeBlock(StoreNewsBlockRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $validated = $request->validated();

        $newsBuilderService->createBlock(
            $article,
            $validated['block_type'],
            $validated,
            $request->file('asset_file'),
            $request->file('asset_files', []),
            Auth::id(),
        );

        return back()->with('success', 'Komponen berita berhasil ditambahkan.');
    }

    public function updateBlock(UpdateNewsBlockRequest $request, NewsArticle $article, int $block, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $resolvedBlock = $this->resolveOwnedBlock($article, $block);

        if (! $resolvedBlock) {
            return redirect()
                ->route('admin.berita.edit', $article)
                ->withErrors(['block' => 'Komponen berita yang ingin diedit tidak ditemukan. Muat ulang halaman lalu coba lagi.']);
        }

        $newsBuilderService->updateBlock(
            $resolvedBlock,
            $request->validated(),
            $request->file('asset_file'),
            $request->file('asset_files', []),
            Auth::id(),
        );

        return back()->with('success', 'Komponen berita berhasil diperbarui.');
    }

    public function destroyBlock(NewsArticle $article, int $block, NewsBuilderService $newsBuilderService): RedirectResponse
    {
        $resolvedBlock = $this->resolveOwnedBlock($article, $block);

        if (! $resolvedBlock) {
            return redirect()
                ->route('admin.berita.edit', $article)
                ->withErrors(['block' => 'Komponen berita yang ingin dihapus tidak ditemukan. Muat ulang halaman lalu coba lagi.']);
        }

        $newsBuilderService->deleteBlock($resolvedBlock, Auth::id());

        return back()->with('success', 'Komponen berita berhasil dihapus.');
    }

    public function reorderBlocks(ReorderNewsBlockRequest $request, NewsArticle $article, NewsBuilderService $newsBuilderService): JsonResponse|RedirectResponse
    {
        $newsBuilderService->reorderBlocks($article, $request->validated()['block_ids'], Auth::id());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Urutan komponen berita berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Urutan komponen berita berhasil diperbarui.');
    }

    private function editorView(NewsArticle $article, NewsContentService $newsContentService, bool $articleExists): View
    {
        $builderReady = $newsContentService->tablesReady();
        $article->loadMissing(['coverAsset', 'tags', 'allBlocks.media.asset', 'submittedBy']);

        /** @var User|null $adminUser */
        $adminUser = Auth::user();
        $resolvedArticle = $articleExists ? $newsContentService->resolveArticle($article) : null;
        $editorSubmitter = $resolvedArticle['submitter'] ?? [
            'role' => 'Admin',
            'name' => trim((string) ($adminUser?->name ?? 'Admin')) ?: 'Admin',
            'identifier' => trim((string) ($adminUser?->username ?? '-')) ?: '-',
            'is_resolved' => (bool) $adminUser,
        ];

        return view('graduation.news_editor', [
            'builderReady' => $builderReady,
            'article' => $article,
            'articleExists' => $articleExists,
            'categories' => $builderReady ? $newsContentService->categories() : collect(),
            'resolvedArticle' => $resolvedArticle,
            'blocks' => $articleExists ? $newsContentService->resolvedBlocks($article) : [],
            'tagsText' => $articleExists ? $article->tags->pluck('tag_name')->implode("\n") : '',
            'editorSubmitter' => $editorSubmitter,
            'portalMode' => 'admin',
        ]);
    }

    private function ensureBlockBelongsToArticle(NewsArticle $article, NewsArticleBlock $block): void
    {
        abort_unless($block->news_article_id === $article->id, 404);
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
