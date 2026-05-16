@extends('layouts.app')

@section('title', $resolved_article['title'] . ' | SMKN 1 Wringin')

@push('styles')
    <style>
        .article-content {
            font-family: 'Inter', sans-serif;
            line-height: 1.8;
            font-size: 1.125rem;
            color: #374151;
        }
        .article-content p {
            margin-bottom: 1.5rem;
        }
        .article-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            line-height: 1.3;
        }
        .article-content blockquote {
            border-left: 4px solid #1E5460;
            padding-left: 1.5rem;
            font-style: italic;
            font-size: 1.25rem;
            color: #4B5563;
            margin: 2.5rem 0;
        }
        .article-content figure {
            margin: 3rem 0;
        }
        @media (max-width: 640px) {
            .article-content figure {
                margin: 2rem 0;
            }
        }
        .article-content figcaption {
            text-align: center;
            font-size: 0.875rem;
            color: #6B7280;
            margin-top: 0.75rem;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
        /* Menyembunyikan scrollbar bawaan browser pada mode geser mobile */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    @php
        $defaultWebpImage = asset('images/webp/default_picture.webp');
        $defaultJpegImage = asset('images/alternative/default_picture.jpeg');
        $cover = $resolved_article['cover'];
    @endphp

    <div class="bg-white min-h-screen pt-32 pb-20">
        <article class="max-w-3xl mx-auto px-4 sm:px-6">
            
            <!-- Title -->
            <h1 class="font-heading text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight tracking-tight">
                {{ $resolved_article['title'] }}
            </h1>

            <!-- Category, Date & Share Actions -->
            <div x-data="{ openShareModal: false, copied: false }" class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-wider rounded-full">
                        {{ $resolved_article['category'] }}
                    </span>
                    <div class="flex items-center gap-1.5 text-gray-400 text-sm">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>{{ $resolved_article['published_label'] }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        @click="openShareModal = true" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 text-gray-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50/50 transition-all text-xs font-bold focus:outline-none"
                    >
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                        <span>Bagikan</span>
                    </button>
                </div>

                <!-- Premium Share Modal -->
                <div 
                    x-show="openShareModal" 
                    x-cloak 
                    @keydown.escape.window="openShareModal = false"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                >
                    <!-- Backdrop with blur -->
                    <div 
                        x-show="openShareModal" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click="openShareModal = false"
                        class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                    ></div>

                    <!-- Modal Content Card -->
                    <div 
                        x-show="openShareModal" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                        class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden p-6 sm:p-8 z-10"
                    >
                        <!-- Header Modal -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="share-2" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Bagikan Artikel</h3>
                                    <p class="text-xs text-gray-500">Sebarkan informasi menarik ini</p>
                                </div>
                            </div>
                            <button 
                                type="button" 
                                @click="openShareModal = false"
                                class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center transition-colors focus:outline-none flex-shrink-0"
                            >
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>

                        <!-- Direct Social Shares -->
                        <div class="grid grid-cols-4 gap-3 mb-6">
                            <!-- WhatsApp -->
                            <a 
                                :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('{{ $resolved_article['title'] }} - ') + encodeURIComponent(window.location.href)" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                aria-label="Bagikan ke WhatsApp"
                                title="WhatsApp"
                                class="inline-flex items-center justify-center p-4 rounded-2xl bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366]/20 transition-all group"
                            >
                                <i class="fab fa-whatsapp text-xl sm:text-2xl group-hover:scale-110 transition-transform"></i>
                            </a>
                            <!-- Facebook -->
                            <a 
                                :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                aria-label="Bagikan ke Facebook"
                                title="Facebook"
                                class="inline-flex items-center justify-center p-4 rounded-2xl bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2]/20 transition-all group"
                            >
                                <i class="fab fa-facebook-f text-lg sm:text-xl group-hover:scale-110 transition-transform"></i>
                            </a>
                            <!-- Twitter / X -->
                            <a 
                                :href="'https://twitter.com/intent/tweet?text=' + encodeURIComponent('{{ $resolved_article['title'] }}') + '&url=' + encodeURIComponent(window.location.href)" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                aria-label="Bagikan ke X"
                                title="X"
                                class="inline-flex items-center justify-center p-4 rounded-2xl bg-gray-900/5 text-gray-900 hover:bg-gray-900/10 transition-all group"
                            >
                                <i class="fab fa-x-twitter text-lg sm:text-xl group-hover:scale-110 transition-transform"></i>
                            </a>
                            <!-- Telegram -->
                            <a 
                                :href="'https://t.me/share/url?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ $resolved_article['title'] }}')" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                aria-label="Bagikan ke Telegram"
                                title="Telegram"
                                class="inline-flex items-center justify-center p-4 rounded-2xl bg-[#0088cc]/10 text-[#0088cc] hover:bg-[#0088cc]/20 transition-all group"
                            >
                                <i class="fab fa-telegram-plane text-lg sm:text-xl group-hover:scale-110 transition-transform"></i>
                            </a>
                        </div>

                        <!-- Copy Link Section -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Salin Tautan</label>
                            <div class="flex items-center gap-2 p-1.5 bg-gray-50 rounded-2xl border border-gray-100">
                                <input 
                                    type="text" 
                                    readonly 
                                    :value="window.location.href" 
                                    class="w-full bg-transparent text-xs text-gray-600 px-3 focus:outline-none truncate font-mono"
                                >
                                <button 
                                    type="button" 
                                    @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all focus:outline-none"
                                    :class="copied ? 'bg-green-600 text-white' : 'bg-brand-600 text-white hover:bg-brand-700'"
                                >
                                    <template x-if="!copied">
                                        <div class="flex items-center gap-1">
                                            <i class="far fa-copy text-sm"></i>
                                            <span>Salin</span>
                                        </div>
                                    </template>
                                    <template x-if="copied">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-check text-sm"></i>
                                            <span>Tersalin</span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($cover['jpeg_url'] ?? null))
                <figure class="mb-12">
                    <div class="aspect-video w-full overflow-hidden rounded-2xl bg-gray-50 border border-gray-100">
                        <picture>
                            @if (!empty($cover['webp_url']))
                                <source srcset="{{ $cover['webp_url'] }}" type="image/webp">
                            @endif
                            <img src="{{ $cover['jpeg_url'] }}" alt="{{ $resolved_article['cover_alt_text'] }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ $defaultJpegImage }}';">
                        </picture>
                    </div>
                </figure>
            @endif

            <!-- Article Content -->
            <div class="article-content">
                @if (!empty($resolved_article['excerpt']))
                    <p>{{ $resolved_article['excerpt'] }}</p>
                @endif

                @foreach ($resolved_article['blocks'] as $block)
                    @include('pages.news_partials.block_renderer', ['block' => $block])
                @endforeach
            </div>

            <!-- Tags -->
            @if (!empty($resolved_article['tags']))
                <div class="mt-12 pt-10 border-t border-gray-100 flex flex-wrap gap-2">
                    @foreach ($resolved_article['tags'] as $tag)
                        <span class="px-4 py-2 bg-gray-50 text-gray-600 text-sm rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif


        </article>

        <!-- More Articles -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-24">
            <h3 class="font-heading text-2xl font-bold text-gray-900 mb-10 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-6 h-6 text-brand-600"></i>
                Baca Juga
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($related_articles as $relatedArticle)
                    <a href="{{ route('berita.detail', ['slug' => $relatedArticle['slug']]) }}" class="group flex flex-col">
                        <div class="aspect-video overflow-hidden rounded-2xl mb-4">
                            <img src="{{ $relatedArticle['cover']['webp_url'] ?? $relatedArticle['cover']['jpeg_url'] ?? $defaultWebpImage }}" alt="{{ $relatedArticle['cover_alt_text'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ $relatedArticle['cover']['jpeg_url'] ?? $defaultJpegImage }}';">
                        </div>
                        <h4 class="font-heading font-bold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-2 mb-4">{{ $relatedArticle['title'] }}</h4>
                        <div class="flex items-center gap-2.5 text-xs mt-auto">
                            <span class="font-bold text-brand-600 uppercase tracking-wider text-[10px] bg-brand-50 px-2.5 py-0.5 rounded-full">{{ $relatedArticle['category'] }}</span>
                            <span class="text-gray-300">•</span>
                            <div class="flex items-center gap-1 text-gray-500">
                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                <time>{{ $relatedArticle['published_label'] }}</time>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-3 rounded-3xl border border-dashed border-slate-200 bg-slate-50 px-8 py-10 text-center text-sm text-slate-500">Belum ada artikel terkait lainnya.</div>
                @endforelse
            </div>
        </section>
    </div>

    @include('partials.footer')
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
@endpush
