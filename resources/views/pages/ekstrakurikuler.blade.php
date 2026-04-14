@extends('layouts.app')

@section('title', 'Ekstrakurikuler - SMKN 1 Wringin')

@section('meta_description', 'Eksplorasi berbagai pilihan ekstrakurikuler di SMKN 1 Wringin. Wadah pengembangan minat, bakat, kepemimpinan, dan kreativitas siswa.')
@section('meta_keywords', 'ekstrakurikuler, pramuka, PMR, futsal, basket, esport, tari, vokal, smkn 1 wringin')

@section('content')
    @include('partials.navbar')

    <main>
        {{-- 1. HERO SECTION --}}
        <section id="home" class="relative min-h-screen flex items-center pt-20 overflow-hidden bg-slate-50">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] bg-brand/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center w-full">
                <div data-animate="fade-up" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand/10 border border-brand/20 text-brand text-xs font-bold uppercase tracking-wide mb-6">
                    EKSTRAKURIKULER
                </div>
                <h1 data-animate="fade-up" data-delay="100" class="text-4xl lg:text-5xl xl:text-6xl font-bold text-slate-900 leading-tight mb-6">
                    Lebih dari Kelas: Wujudkan Minat, <span class="text-brand relative inline-block">Temukan Bakatmu<svg class="absolute w-full h-3 -bottom-1 left-0 text-secondary/40" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="transparent"/></svg></span>
                </h1>
                <p data-animate="fade-up" data-delay="200" class="text-lg text-slate-600 mb-10 leading-relaxed font-medium max-w-2xl mx-auto">
                    Kami percaya masa depan tidak hanya dibangun di laboratorium dan ruang teori. Melalui berbagai pilihan ekstrakurikuler, asah kepemimpinan, kerja sama tim, dan kreativitasmu di lapangan nyata.
                </p>
                <div data-animate="fade-up" data-delay="300" class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#kategori" class="px-8 py-4 bg-brand hover:bg-brand-700 text-white font-bold rounded-full shadow-xl shadow-brand/20 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Mulai Eksplorasi <i class="fa-solid fa-arrow-down"></i>
                    </a>
                    <a href="#pentingnya" class="px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-full border border-slate-200 shadow-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-info text-brand"></i> Mengapa Penting?
                    </a>
                </div>
            </div>
        </section>

        {{-- 2. INTRODUCTION SECTION --}}
        <section id="pentingnya" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12 items-center">
                    <div class="lg:w-1/2" data-animate="fade-right">
                        <h2 class="text-brand font-bold tracking-wide uppercase text-sm mb-3">Pentingnya Ekstrakurikuler</h2>
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">Mengapa Harus Bergabung?</h3>
                        <p class="text-slate-600 text-lg leading-relaxed mb-6">
                            Rutinitas belajar teknis perlu diimbangi dengan ruang berekspresi. Di sini, kamu tidak hanya sekadar berkumpul. Kamu berlatih menghadapi dinamika organisasi, mengelola ego dalam tim olahraga, serta memecahkan masalah praktis yang tidak pernah diajarkan di buku teks.
                        </p>
                        <p class="text-slate-600 text-lg leading-relaxed font-medium">
                            Ini adalah simulasi nyata yang membekalimu sebelum terjun ke kehidupan sosial dan profesional.
                        </p>
                    </div>
                    <div class="lg:w-1/2 grid grid-cols-2 gap-4" data-animate="fade-left">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col items-center text-center transition hover:shadow-md">
                            <div class="w-12 h-12 bg-brand/10 text-brand rounded-full flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-people-group"></i></div>
                            <h4 class="font-bold text-slate-900">Kerja Sama Tim</h4>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col items-center text-center transition hover:shadow-md">
                            <div class="w-12 h-12 bg-secondary/20 text-secondary rounded-full flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-compass"></i></div>
                            <h4 class="font-bold text-slate-900">Kepemimpinan</h4>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col items-center text-center transition hover:shadow-md">
                            <div class="w-12 h-12 bg-brand/10 text-brand rounded-full flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-stopwatch"></i></div>
                            <h4 class="font-bold text-slate-900">Kedisiplinan</h4>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col items-center text-center transition hover:shadow-md">
                            <div class="w-12 h-12 bg-secondary/20 text-secondary rounded-full flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-lightbulb"></i></div>
                            <h4 class="font-bold text-slate-900">Kreativitas</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. EXTRACURRICULAR GRID --}}
        <section id="kategori" class="py-24 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-12" data-animate="fade-up">
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Pilihan Kami.</h2>
                    <p class="text-slate-500 text-lg md:text-xl max-w-2xl">
                        Daftar ekstrakurikuler terbaik yang diseleksi untuk mengembangkan potensi siswa di berbagai bidang.
                    </p>
                </div>

                <!-- Masonry Grid Layout (4 Columns) -->
                <div class="columns-1 sm:columns-2 lg:columns-4 gap-6 space-y-6">
                    
                    @php
                        $extras = [
                            [
                                'name' => 'Pramuka',
                                'category' => 'Organisasi',
                                'desc' => 'Bertahan Hidup & Tumbuh Tangguh di Alam Bebas',
                                'img' => 'https://images.unsplash.com/photo-1533604101087-43f1146244be?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[400px]',
                                'days' => 'Jumat, Sabtu',
                                'time' => '15.30 WIB',
                                'color' => 'teal'
                            ],
                            [
                                'name' => 'Palang Merah Remaja',
                                'category' => 'Sosial & Medis',
                                'desc' => 'Garda Terdepan Penyelamat Nyawa',
                                'img' => 'https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[350px]',
                                'days' => 'Rabu, Jumat',
                                'time' => '16.00 WIB',
                                'color' => 'rose'
                            ],
                            [
                                'name' => 'Seni Hadrah',
                                'category' => 'Seni & Budaya',
                                'desc' => 'Harmoni Nada Sakral dan Lantunan Selawat',
                                'img' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[450px]',
                                'days' => 'Selasa, Kamis',
                                'time' => '15.30 WIB',
                                'color' => 'amber'
                            ],
                            [
                                'name' => 'Sepak Bola & Futsal',
                                'category' => 'Olahraga',
                                'desc' => 'Aksi Lapangan Hijau dan Taktik Juara',
                                'img' => 'https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[380px]',
                                'days' => 'Senin, Rabu',
                                'time' => '15.30 WIB',
                                'color' => 'blue'
                            ],
                            [
                                'name' => 'Bola Basket',
                                'category' => 'Olahraga',
                                'desc' => 'Terbang Tinggi Cetak Tiga Angka Gemilang',
                                'img' => 'https://images.unsplash.com/photo-1519861531473-920026073fdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[420px]',
                                'days' => 'Selasa, Kamis',
                                'time' => '16.00 WIB',
                                'color' => 'orange'
                            ],
                            [
                                'name' => 'Bola Voli',
                                'category' => 'Olahraga',
                                'desc' => 'Lompatan Akurat Menuju Kemenangan Tim',
                                'img' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[360px]',
                                'days' => 'Senin, Rabu',
                                'time' => '16.00 WIB',
                                'color' => 'cyan'
                            ],
                            [
                                'name' => 'E-Sports Club',
                                'category' => 'E-Sports',
                                'desc' => 'Adu Strategi Digital di Arena Profesional',
                                'img' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[400px]',
                                'days' => 'Jumat',
                                'time' => '14.00 WIB',
                                'color' => 'purple'
                            ],
                            [
                                'name' => 'Seni Tari & Vokal',
                                'category' => 'Seni & Budaya',
                                'desc' => 'Ekspresikan Jiwa Lewat Gerak dan Nada',
                                'img' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[480px]',
                                'days' => 'Rabu, Sabtu',
                                'time' => '15.00 WIB',
                                'color' => 'pink'
                            ],
                            [
                                'name' => 'VM Media',
                                'category' => 'Teknologi',
                                'desc' => 'Rekam Momen & Ciptakan Karya Visual',
                                'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[380px]',
                                'days' => 'Kamis',
                                'time' => '15.30 WIB',
                                'color' => 'emerald'
                            ],
                            [
                                'name' => 'Sains Club',
                                'category' => 'Akademik',
                                'desc' => 'Menembus Batas Logika & Inovasi Sains',
                                'img' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                'height' => 'h-[400px]',
                                'days' => 'Selasa',
                                'time' => '15.30 WIB',
                                'color' => 'indigo'
                            ],
                        ];
                    @endphp

                    @foreach($extras as $extra)
                    <div data-animate="zoom-in" class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer break-inside-avoid {{ $extra['height'] }}">
                        <img src="{{ $extra['img'] }}" alt="{{ $extra['name'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        
                        <!-- Bottom to Top Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/50 to-transparent opacity-90 group-hover:opacity-100 transition-opacity"></div>
                        
                        <!-- Content Anchored to Bottom -->
                        <div class="relative h-full flex flex-col justify-end p-6 z-10 transform transition-transform duration-300 group-hover:-translate-y-1">
                            <span class="text-[10px] font-bold tracking-widest text-{{ $extra['color'] }}-300 uppercase mb-1 block">{{ $extra['category'] }}</span>
                            <h3 class="text-2xl font-bold text-white mb-2 leading-tight">{{ $extra['name'] }}</h3>
                            <p class="text-sm text-slate-300 mb-4 line-clamp-2">{{ $extra['desc'] }}</p>
                            
                            <!-- Schedule -->
                            <div class="flex items-center gap-3 text-xs font-medium text-slate-200 border-t border-white/20 pt-4">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-calendar-days text-{{ $extra['color'] }}-400"></i>
                                    <span>{{ $extra['days'] }}</span>
                                </div>
                                <span class="text-white/30">|</span>
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-clock text-{{ $extra['color'] }}-400"></i>
                                    <span>{{ $extra['time'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
@endsection
