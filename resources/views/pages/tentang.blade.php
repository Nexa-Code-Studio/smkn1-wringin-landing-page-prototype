@extends('layouts.app')

@section('title', $profilContent['title'] ?? 'Tentang Kami - SMKN 1 Wringin')

@section('content')
    @include('partials.navbar')

    @php
        $defaultWebpImage = asset('images/webp/default_picture.webp');
        $defaultJpegImage = asset('images/alternative/default_picture.jpeg');
        $profilMeta = array_merge([
            'hero_badge_text' => '22 Tahun Mengabdi',
            'hero_title' => 'Mengenal Lebih Dekat SMKN 1 Wringin',
            'hero_description' => 'Menjadi SMK Pusat Keunggulan yang mencetak generasi Creativepreneur berkarakter, siap bersaing di dunia industri dan usaha.',
            'sejarah_title' => 'Sejarah Berdirinya SmakinOne',
            'sejarah_body' => "SMK Negeri 1 Wringin berdiri pada 01 September 2004 berdasarkan SK Ijin Pendirian dan Operasional Nomor: 4215/2074.a/430.520/2004. Kehadirannya berangkat dari upaya meningkatkan angka partisipasi sekolah tamatan SMP yang cukup rendah, melalui program SMK Kecil di SMP di bawah naungan Pemerintah Kabupaten Bondowoso. Program ini menjadi strategi pemerataan akses pendidikan, sehingga hampir setiap kecamatan memiliki SMK dengan karakteristik keahlian sesuai potensi wilayah.\n\nPada awalnya, SMKN 1 Wringin menjalankan kegiatan pembelajaran bersama SMPN 1 Wringin dengan berbagi lahan, membuka dua konsentrasi keahlian: Teknik Audio Video dan Teknik Bangunan. Seiring meningkatnya minat dan kebutuhan masyarakat, sekolah terus beradaptasi dengan membuka Teknik Komputer dan Jaringan pada tahun 2006, serta Desain Komunikasi Visual pada tahun 2011.\n\nDan sejak tahun 2015, pengelolaan pendidikan menengah berada di bawah Dinas Pendidikan Provinsi Jawa Timur, namun komitmen untuk mencetak putra-putri daerah tetap menjadi ruh utama. Kini, SMKN 1 Wringin atau SmakinOne berkembang dengan empat konsentrasi keahlian: TAV, TKJ, DKV, dan Teknik Kendaraan Ringan Otomotif (TKRO). SmakinOne semakin dikenal sebagai SMK Pusat Keunggulan bidang Ekonomi Kreatif yang sukses mengembangkan pembelajaran Teaching Factory sebagai jembatan menuju dunia usaha dan industri.",
            'keunggulan_intro' => 'Lingkungan belajar yang holistik untuk mencetak talenta-talenta siap kerja dan siap berkarya.',
            'keunggulan_items' => "Lingkungan belajar yang representatif dan kondusif\nFasilitas serta sarana-prasarana pembelajaran berorientasi lingkungan serta berbasis teknologi\nProgram Link and Match\nPengelolaan kegiatan pembelajaran yang kontekstual melalui kemitraan dengan industri dan masyarakat\nTenaga Guru dan Kependidikan yang Profesional\nGTK dengan sertifikasi pendidik dan pengalaman industri\nPengembangan Potensi\nProgram pengembangan bakat dan",
            'visi_title' => 'Terwujudnya Lulusan SMAKIN KEREN',
            'visi_body' => 'Lulusan SMKN 1 Wringin sebagai Creativepreneur Berkarakter',
            'misi_items' => "Membina keimanan dan ketaqwaan kepada Tuhan Yang Maha Esa serta akhlak mulia\nMenyelenggarakan pendidikan vokasi untuk mencapai 8 dimensi profil lulusan\nMeningkatkan profesionalisme Guru dan Tenaga Kependidikan\nMeningkatkan mutu layanan pendidikan melalui pemenuhan sarana-prasarana berbasis teknologi\nMeningkatkan kerjasama dan kolaborasi dengan seluruh pemangku kepentingan",
            'motto_text' => 'Creativepreneurs Start Here',
            'cta_title' => 'Bergabunglah Bersama Keluarga Besar Kami',
            'cta_description' => 'Jadilah bagian dari generasi penerus yang inovatif, berkarakter, dan siap menghadapi tantangan masa depan bersama SMKN 1 Wringin.',
        ], $profilContent['meta'] ?? []);
        $sejarahParagraphs = collect(preg_split('/\R{2,}/', trim((string) ($profilMeta['sejarah_body'] ?? ''))) ?: [])->map(fn (string $item) => trim($item))->filter()->values();
        $keunggulanItems = collect(preg_split('/\R+/', trim((string) ($profilMeta['keunggulan_items'] ?? ''))) ?: [])->map(fn (string $item) => trim($item))->filter()->values();
        $misiItems = collect(preg_split('/\R+/', trim((string) ($profilMeta['misi_items'] ?? ''))) ?: [])->map(fn (string $item) => trim($item))->filter()->values();
        $keunggulanIcons = ['fa-tree', 'fa-laptop-code', 'fa-handshake', 'fa-industry', 'fa-chalkboard-user', 'fa-seedling', 'fa-lightbulb', 'fa-users'];
        $misiIcons = ['fa-star', 'fa-graduation-cap', 'fa-chalkboard-user', 'fa-microchip', 'fa-handshake-angle'];
    @endphp

    <!-- 1. HERO SECTION -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-slate-50 min-h-[100dvh] flex flex-col justify-center">
        <!-- Subtle Pattern Background -->
        <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-100 text-orange-600 font-bold text-sm mb-6 border border-orange-200 shadow-sm">
                <i class="fa-solid fa-award"></i> {{ $profilMeta['hero_badge_text'] }}
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
                {!! nl2br(e($profilMeta['hero_title'])) !!}
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed">
                {{ $profilMeta['hero_description'] }}
            </p>
        </div>
    </section>

    <!-- 2. SEJARAH -->
    <section class="py-20 lg:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
                <div class="lg:col-span-5 relative">
                    <!-- Image / Decoration -->
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100">
                        <div class="aspect-[4/5] bg-slate-100 relative">
                            <img src="{{ $defaultWebpImage }}" onerror="this.onerror=null;this.src='{{ $defaultJpegImage }}';" alt="Gedung SMKN 1 Wringin" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                            <div class="absolute bottom-8 left-8 right-8 text-white">
                                <p class="text-3xl font-extrabold mb-1">Sejak 2004</p>
                                <p class="text-sm font-medium text-slate-200">Melangkah bersama membangun potensi daerah.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-brand-100 rounded-full -z-10 blur-2xl opacity-70"></div>
                </div>
                
                <div class="lg:col-span-7">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-3 block">Sejarah Berdiri</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-8 leading-tight">{{ $profilMeta['sejarah_title'] }}</h2>
                    
                    <div class="space-y-6 text-slate-600 text-lg leading-relaxed">
                        @foreach ($sejarahParagraphs as $index => $paragraph)
                            @if ($loop->last)
                                <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl mt-8">
                                    <p class="text-slate-700">{{ $paragraph }}</p>
                                </div>
                            @else
                                <p>{{ $paragraph }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. KEUNGGULAN -->
    <section class="py-20 lg:py-28 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-3 block">Nilai Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">Poin Keunggulan Utama</h2>
                <p class="text-slate-500 text-lg">{{ $profilMeta['keunggulan_intro'] }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($keunggulanItems as $index => $item)
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-brand-100 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{ $keunggulanIcons[$index % count($keunggulanIcons)] }}"></i>
                        </div>
                        <p class="text-slate-500 leading-relaxed font-medium">{{ $item }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. VISI, MISI, MOTTO -->
    <section class="py-20 lg:py-28 bg-brand-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                <!-- Visi & Motto -->
                <div class="text-white space-y-12">
                    <div>
                        <span class="text-brand-300 font-bold tracking-wider uppercase text-sm mb-3 block">Motto Kami</span>
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight font-serif italic">
                            "{{ $profilMeta['motto_text'] }}"
                        </h2>
                    </div>

                    <div class="p-8 bg-white/10 backdrop-blur-sm rounded-3xl border border-white/20 relative">
                        <div class="absolute -top-5 -right-5 text-6xl text-brand-400 opacity-30">
                            <i class="fa-solid fa-quote-right"></i>
                        </div>
                        <span class="text-brand-300 font-bold tracking-wider uppercase text-sm mb-4 block">Visi Utama</span>
                        <p class="text-2xl font-bold text-white mb-2 leading-snug">{{ $profilMeta['visi_title'] }}</p>
                        <p class="text-brand-100 text-lg">{{ $profilMeta['visi_body'] }}</p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-2xl">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-3 block">Misi Kami</span>
                    <h3 class="text-3xl font-bold text-slate-900 mb-8">Langkah Nyata Mencapai Visi</h3>
                    
                    <ul class="space-y-6">
                        @foreach ($misiItems as $index => $item)
                            <li class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fa-solid {{ $misiIcons[$index % count($misiIcons)] }} text-sm"></i>
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $item }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </section>

    <!-- 5. CTA PENUTUP -->
    <section class="py-20 bg-white border-t border-slate-100 text-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-slate-900 mb-6">{{ $profilMeta['cta_title'] }}</h2>
            <p class="text-slate-500 mb-10 text-lg">{{ $profilMeta['cta_description'] }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('ppdb') }}" class="px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-full shadow-lg hover:shadow-brand-600/30 transition-all flex items-center gap-2">
                    Informasi Pendaftaran <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="#contact" class="px-8 py-3.5 bg-white border-2 border-slate-200 hover:border-brand-200 hover:bg-slate-50 text-slate-700 font-bold rounded-full transition-all flex items-center gap-2">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
