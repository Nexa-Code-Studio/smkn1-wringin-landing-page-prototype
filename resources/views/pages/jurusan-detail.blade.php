@extends('layouts.app')

@section('title', $jurusan['name'] . ' - SMKN 1 Wringin')

@section('content')
    @include('partials.navbar')

    {{-- DESKRIPSI & INFO SINGKAT --}}
    <section id="deskripsi" class="relative min-h-screen pt-32 pb-16 flex items-center overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <picture>
                @if(! empty($jurusan['hero_image_webp']))
                    <source srcset="{{ $jurusan['hero_image_webp'] }}" type="image/webp">
                @endif
                <img src="{{ $jurusan['hero_image'] }}" alt="{{ $jurusan['hero_image_alt'] }}" class="w-full h-full object-cover">
            </picture>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/80 to-brand-900/40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-3 gap-12">
                
                {{-- Main Content / Deskripsi --}}
                <div class="lg:col-span-2" data-animate="fade-right">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-8 flex items-center gap-3">
                        <span class="w-12 h-1.5 bg-secondary rounded-full"></span>
                        Mengenal Jurusan {{ $jurusan['short'] }}
                    </h2>
                    
                    <div class="prose prose-invert prose-slate max-w-none text-slate-200 leading-relaxed space-y-6 text-lg font-light">
                        @foreach ($jurusan['description'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>

                {{-- Sidebar / Quick Facts --}}
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-2xl h-fit" data-animate="fade-left" data-delay="200">
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Info Program Keahlian</h3>
                    @php
                        $kompetensiItems = is_array($jurusan['kompetensi']) ? $jurusan['kompetensi'] : [$jurusan['kompetensi']];
                        $mitraItems = is_array($jurusan['mitra']) ? $jurusan['mitra'] : [$jurusan['mitra']];
                    @endphp
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-secondary rounded-2xl flex items-center justify-center text-slate-900 flex-shrink-0 group-hover:scale-110 transition duration-300 shadow-lg shadow-secondary/20">
                                <i class="fa-solid fa-clock text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-widest">Masa Studi</p>
                                <p class="font-bold text-white text-lg">3 Tahun</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white flex-shrink-0 group-hover:bg-brand-500 transition duration-300 border border-white/10">
                                <i class="fa-solid fa-laptop-code text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-widest">Kompetensi Utama</p>
                                <ul class="mt-2 space-y-2 text-sm text-slate-200">
                                    @foreach ($kompetensiItems as $item)
                                        <li class="leading-relaxed flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-brand-400 rounded-full"></span>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white flex-shrink-0 group-hover:bg-brand-500 transition duration-300 border border-white/10">
                                <i class="fa-solid fa-building-circle-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-widest">Mitra Industri</p>
                                <ul class="mt-2 space-y-2 text-sm text-slate-200">
                                    @foreach ($mitraItems as $item)
                                        <li class="leading-relaxed flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 bg-secondary rounded-full"></span>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- KEUNGGULAN PROGRAM --}}
    <section class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-animate="fade-up">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Nilai Tambah</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900">Keunggulan {{ $jurusan['short'] }} SMKN 1 Wringin</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($jurusan['advantages'] as $index => $advantage)
                    <div data-animate="fade-up" data-delay="{{ ($index + 1) * 100 }}" class="bg-white p-8 rounded-2xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out group">
                        <div class="w-14 h-14 bg-brand-600/10 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition duration-500">
                            <i class="fa-solid {{ $advantage['icon'] }} text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-3">{{ $advantage['title'] }}</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $advantage['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALERI / FOTO PROGRAM --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4" data-animate="fade-up">
                <div class="max-w-2xl">
                    <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Fasilitas & Kegiatan</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900">Galeri Jurusan {{ $jurusan['short'] }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach(($jurusan['gallery_images'] ?? []) as $index => $galleryImage)
                    <div data-animate="zoom-in" @if($index > 0) data-delay="{{ $index * 100 }}" @endif class="{{ $index === 0 ? 'col-span-2 md:col-span-2 row-span-2 h-64 md:h-full shadow-lg' : 'h-48 md:h-64 shadow-md' }} relative group overflow-hidden rounded-2xl">
                        <picture>
                            @if(! empty($galleryImage['webp_url']))
                                <source srcset="{{ $galleryImage['webp_url'] }}" type="image/webp">
                            @endif
                            <img src="{{ $galleryImage['jpeg_url'] }}" alt="{{ $galleryImage['alt'] }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" decoding="async" loading="lazy">
                        </picture>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end {{ $index === 0 ? 'p-6' : 'p-4' }}">
                            <span class="text-white {{ $index === 0 ? 'font-semibold text-lg' : 'font-medium text-sm' }}">{{ $galleryImage['caption'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
