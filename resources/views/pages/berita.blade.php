@extends('layouts.app')

@section('title', 'Berita & Artikel | SMKN 1 Wringin')

@push('styles')
    <style>
        /* Pattern Hero */
        .hero-pattern-berita {
            background-color: #fafafa;
            background-image: radial-gradient(#e2e8f0 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }

        /* Animasi fade in */
        .fade-in-berita {
            animation: fadeInB 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }

        @keyframes fadeInB {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Line Clamp untuk memotong teks panjang */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    @php
        $defaultWebpImage = asset('images/webp/default_picture.webp');
        $defaultJpegImage = asset('images/alternative/default_picture.jpeg');
        $mainFeatured = $featured_articles[0] ?? null;
        $sideFeatured = array_slice($featured_articles, 1, 3);
        $currentPage = $articles->currentPage();
        $lastPage = $articles->lastPage();
        $paginationPages = collect(range(max(1, $currentPage - 1), min($lastPage, $currentPage + 1)));

        if ($lastPage > 0 && ! $paginationPages->contains(1)) {
            $paginationPages->prepend(1);
        }

        if ($lastPage > 1 && ! $paginationPages->contains($lastPage)) {
            $paginationPages->push($lastPage);
        }

        $paginationPages = $paginationPages->unique()->values();
    @endphp

    <div class="hero-pattern-berita text-slate-700 antialiased min-h-screen flex flex-col font-sans">
        <main class="flex-grow pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            <!-- Section: Featured Articles (Layout Atas) -->
            <section class="mb-20 fade-in-berita">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    @if ($mainFeatured)
                        <a href="{{ route('berita.detail', ['slug' => $mainFeatured['slug']]) }}" class="lg:col-span-8 relative rounded-3xl overflow-hidden group cursor-pointer h-[400px] sm:h-[500px]">
                            <img src="{{ $mainFeatured['cover']['webp_url'] ?? $mainFeatured['cover']['jpeg_url'] ?? $defaultWebpImage }}" alt="{{ $mainFeatured['cover_alt_text'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ $mainFeatured['cover']['jpeg_url'] ?? $defaultJpegImage }}';">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8 sm:p-10 w-full">
                                <div class="mb-4 flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-brand-100">
                                    <span>{{ $mainFeatured['category'] }}</span>
                                    <span class="text-white/40">•</span>
                                    <time>{{ $mainFeatured['published_label'] }}</time>
                                </div>
                                <h2 class="text-2xl sm:text-3xl md:text-4xl font-heading font-bold text-white mb-4 leading-tight group-hover:text-brand-100 transition-colors">{{ $mainFeatured['title'] }}</h2>
                                <p class="text-gray-300 text-sm sm:text-base line-clamp-2 max-w-3xl">{{ $mainFeatured['excerpt'] }}</p>
                            </div>
                        </a>
                    @else
                        <div class="lg:col-span-8 rounded-3xl border border-dashed border-slate-200 bg-white/70 p-10 text-center text-slate-500">
                            Highlight berita akan muncul di sini setelah admin memilih 4 berita published.
                        </div>
                    @endif

                    <!-- Side Featured Posts (Kanan - List Kecil) -->
                    <div class="lg:col-span-4 flex flex-col gap-5 justify-between">
                        @forelse ($sideFeatured as $article)
                            <a href="{{ route('berita.detail', ['slug' => $article['slug']]) }}" class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex gap-4 items-center group cursor-pointer hover:shadow-md transition-all h-full">
                                <div class="w-32 h-28 shrink-0 overflow-hidden rounded-2xl">
                                    <img src="{{ $article['cover']['webp_url'] ?? $article['cover']['jpeg_url'] ?? $defaultWebpImage }}" alt="{{ $article['cover_alt_text'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ $article['cover']['jpeg_url'] ?? $defaultJpegImage }}';">
                                </div>
                                <div class="flex-grow flex flex-col justify-center">
                                    <h3 class="font-heading font-semibold text-gray-900 text-sm sm:text-base leading-snug mb-3 group-hover:text-brand-600 line-clamp-2">{{ $article['title'] }}</h3>
                                    <div class="flex items-center gap-2 text-xs mt-auto">
                                        <span class="font-bold text-brand-600 uppercase tracking-wider text-[10px] bg-brand-50 px-2 py-0.5 rounded-full">{{ $article['category'] }}</span>
                                        <span class="text-gray-300">•</span>
                                        <div class="flex items-center gap-1 text-gray-500 text-[11px]">
                                            <i data-lucide="calendar" class="w-3 h-3"></i>
                                            <time>{{ $article['published_label'] }}</time>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="rounded-3xl border border-dashed border-slate-200 bg-white/70 p-6 text-sm text-slate-500">Tambahkan lebih banyak berita published untuk melengkapi slot highlight samping.</div>
                        @endforelse

                    </div>
                </div>
            </section>

            <!-- Section: Latest Articles (Grid Bawah) -->
            <section class="fade-in-berita delay-100">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-10">
                    <h2 class="font-heading text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                        Jelajahi <span class="relative inline-block pb-2">Berita Terbaru
                            <!-- Garis bawah melingkar/hijau khas desain -->
                            <span class="absolute bottom-0 left-0 w-full h-1.5 bg-brand-500 rounded-full"></span>
                        </span>
                    </h2>
                    <p class="text-gray-500 text-sm max-w-sm md:text-right leading-relaxed">
                        Ikuti terus perkembangan, kegiatan sekolah, dan berbagai pencapaian luar biasa dari siswa-siswi kami.
                    </p>
                </div>

                <!-- Grid 6 Artikel -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($articles as $article)
                        <a href="{{ route('berita.detail', ['slug' => $article['slug']]) }}" class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">
                            <div class="h-56 overflow-hidden">
                                <img src="{{ $article['cover']['webp_url'] ?? $article['cover']['jpeg_url'] ?? $defaultWebpImage }}" alt="{{ $article['cover_alt_text'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ $article['cover']['jpeg_url'] ?? $defaultJpegImage }}';">
                            </div>
                            <div class="p-6 sm:p-8 flex flex-col flex-grow">
                                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-4 line-clamp-2 group-hover:text-brand-600 transition-colors">{{ $article['title'] }}</h3>
                                @if (!empty($article['excerpt']))
                                    <p class="mb-6 text-sm leading-7 text-gray-500 line-clamp-3">{{ $article['excerpt'] }}</p>
                                @endif
                                <div class="flex items-center gap-2.5 text-xs mt-auto">
                                    <span class="font-bold text-brand-600 uppercase tracking-wider text-[10px] bg-brand-50 px-2.5 py-0.5 rounded-full">{{ $article['category'] }}</span>
                                    <span class="text-gray-300">•</span>
                                    <div class="flex items-center gap-1 text-gray-500">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        <time>{{ $article['published_label'] }}</time>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="md:col-span-2 lg:col-span-3 rounded-3xl border border-dashed border-slate-200 bg-white px-8 py-14 text-center">
                            <p class="text-lg font-bold text-slate-700">Belum ada berita publik pada kategori ini.</p>
                            <p class="mt-2 text-sm text-slate-500">Admin dapat mem-publish berita dari dashboard admin berita.</p>
                        </div>
                    @endforelse

                </div>

                <!-- Komponen Paginasi -->
                @if ($articles->hasPages())
                    <div class="mt-16 flex justify-center items-center">
                        <nav class="inline-flex flex-wrap items-center gap-2" aria-label="Pagination">
                            @if ($articles->onFirstPage())
                                <span class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-300 rounded-xl opacity-50 cursor-not-allowed">
                                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                                </span>
                            @else
                                <a href="{{ $articles->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-brand-600 rounded-xl transition-colors">
                                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                                </a>
                            @endif

                            <div class="flex items-center gap-1">
                                @foreach ($paginationPages as $index => $page)
                                    @if ($index > 0 && $page - $paginationPages[$index - 1] > 1)
                                        <span class="w-10 h-10 flex items-center justify-center text-gray-400 font-semibold">...</span>
                                    @endif

                                    @if ($page === $currentPage)
                                        <span class="w-10 h-10 flex items-center justify-center bg-brand-600 text-white font-semibold rounded-xl shadow-sm transition-colors">{{ $page }}</span>
                                    @else
                                        <a href="{{ $articles->url($page) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 hover:bg-brand-50 hover:text-brand-600 hover:border-brand-200 font-semibold rounded-xl transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>

                            @if ($articles->hasMorePages())
                                <a href="{{ $articles->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-brand-600 rounded-xl transition-colors">
                                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                </a>
                            @else
                                <span class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-300 rounded-xl opacity-50 cursor-not-allowed">
                                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
                
            </section>

        </main>
    </div>

    @include('partials.footer')
@endsection

@push('scripts')
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();
    </script>
@endpush
