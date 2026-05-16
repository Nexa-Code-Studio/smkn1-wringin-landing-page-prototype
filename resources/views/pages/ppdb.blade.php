@extends('layouts.app')

@section('title', ($ppdbContent['title'] ?? 'Informasi PPDB').' - SMKN 1 Wringin')

@push('styles')
<style>
    .article-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        color: #334155;
        font-size: 1.125rem;
    }

    .article-content h2 {
        font-size: 1.875rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 3rem;
        margin-bottom: 1rem;
    }

    .article-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
        color: #334155;
        font-size: 1.125rem;
        line-height: 1.8;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
    @include('partials.navbar')

    @php
        $blocks = $ppdbContent['blocks'] ?? [];
        $updatedAt = $ppdbContent['updated_at'] ?? null;
        $updatedLabel = !empty($updatedAt) ? \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
        $updatedTime = !empty($updatedAt) ? \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('H:i') . ' WIB' : now()->translatedFormat('H:i') . ' WIB';
    @endphp

    <header class="bg-white pb-10 pt-32">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-brand">
                <i class="fa-solid fa-calendar-check text-secondary"></i>
                {{ $ppdbContent['badge_text'] ?? 'Informasi Resmi PPDB' }}
            </div>

            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl">
                {{ $ppdbContent['title'] ?? 'Informasi PPDB' }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-4 text-sm font-medium text-slate-500">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand text-xs text-white">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span>Panitia PPDB</span>
                </div>
                <span class="hidden sm:inline">•</span>
                <span>Diperbarui {{ $updatedLabel }}</span>
                <span class="hidden sm:inline">•</span>
                <span><i class="fa-regular fa-clock"></i> {{ $updatedTime }}</span>
            </div>
        </div>
    </header>

    <main class="min-h-screen bg-white py-10">
        <div class="article-content mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @forelse ($blocks as $block)
                @include('pages.ppdb_partials.block_renderer', ['block' => $block, 'isBuilderPreview' => false])
            @empty
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center">
                    <p class="text-base font-bold text-slate-700">Konten PPDB belum tersedia.</p>
                    <p class="mt-2 text-sm font-medium text-slate-500">Admin dapat menambahkan blok dari halaman builder PPDB.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('partials.footer')
@endsection
