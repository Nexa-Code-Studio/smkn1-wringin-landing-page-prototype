@extends('layouts.app')

@section('title', 'Program Pembelajaran | SMKN 1 Wringin')

@push('styles')
    <style>
        /* Pattern Hero */
        .hero-pattern-pembelajaran {
            background-color: #ffffff;
            background-image: radial-gradient(#e2e8f0 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }

        /* Animasi fade in */
        .fade-in-pembelajaran {
            animation: fadeInP 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

        @keyframes fadeInP {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glassmorphism */
        .glass-card-pembelajaran {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <div class="hero-pattern-pembelajaran text-slate-700 antialiased min-h-screen flex flex-col font-sans">
        <main class="flex-grow pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            
            <!-- Hero Section -->
            <section class="text-center max-w-4xl mx-auto fade-in-pembelajaran mb-20">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-700 text-xs sm:text-sm font-medium mb-6">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                    Akademik & Pembelajaran
                </div>
                
                <h1 class="font-heading text-4xl sm:text-5xl font-bold text-gray-900 mb-6 tracking-tight leading-tight">
                    Membentuk Lulusan <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-800">Kompeten & Siap Kerja</span>
                </h1>
                
                <p class="text-base sm:text-lg text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto">
                    Di SMKN 1 Wringin, Anda tidak hanya belajar teori. Kami menerapkan sistem pembelajaran berbasis proyek nyata dan praktik langsung yang disesuaikan dengan standar industri saat ini.
                </p>
            </section>

            <!-- Sistem Pendekatan Belajar -->
            <section id="pendekatan" class="mb-24 fade-in-pembelajaran delay-100">
                <div class="text-center mb-12">
                    <h2 class="font-heading text-3xl font-bold text-gray-900 mb-4">Bagaimana Anda Belajar?</h2>
                    <div class="h-1 w-20 bg-brand-500 rounded-full mx-auto"></div>
                </div>

                <div class="grid sm:grid-cols-3 gap-6">
                    <!-- Pendekatan 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center mb-6">
                            <i data-lucide="hammer" class="w-7 h-7"></i>
                        </div>
                        <h3 class="font-heading font-semibold text-gray-900 text-xl mb-3">70% Praktik Industri</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Porsi belajar lebih banyak dihabiskan di laboratorium dan bengkel kerja. Siswa dilatih melakukan simulasi pekerjaan riil menggunakan alat standar industri, bukan sekadar menghafal buku.
                        </p>
                    </div>
                    
                    <!-- Pendekatan 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                            <i data-lucide="blocks" class="w-7 h-7"></i>
                        </div>
                        <h3 class="font-heading font-semibold text-gray-900 text-xl mb-3">Project Based Learning</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Siswa akan diberikan proyek nyata untuk diselesaikan secara berkelompok. Mengasah kemampuan memecahkan masalah (problem solving), kerja tim, dan berpikir kritis.
                        </p>
                    </div>

                    <!-- Pendekatan 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <i data-lucide="briefcase" class="w-7 h-7"></i>
                        </div>
                        <h3 class="font-heading font-semibold text-gray-900 text-xl mb-3">Praktek Kerja Lapangan</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Program magang (PKL) langsung di perusahaan mitra selama 6 bulan. Memberikan pengalaman kerja sungguhan, budaya kerja, dan relasi sebelum lulus sekolah.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Program Keahlian / Jurusan -->
            <section id="jurusan" class="mb-24 fade-in-pembelajaran delay-200">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-6">
                    <div class="max-w-2xl">
                        <h2 class="font-heading text-3xl font-bold text-gray-900 mb-4">Program Keahlian Pilihan</h2>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Temukan minat dan bakat Anda pada program keahlian unggulan yang kami sediakan. Kurikulum disusun bersama mitra industri (Link and Match).
                        </p>
                    </div>
                </div>

                <!-- Grid Jurusan -->
                <div class="grid lg:grid-cols-2 gap-8">
                    
                    <!-- Jurusan 1: RPL -->
                    <div class="glass-card-pembelajaran rounded-3xl overflow-hidden group hover:border-brand-300 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-4 bg-slate-100 rounded-2xl text-slate-700 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                    <i data-lucide="code-2" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <h3 class="font-heading text-2xl font-bold text-gray-900">Rekayasa Perangkat Lunak</h3>
                                    <p class="text-sm font-medium text-brand-600">Teknologi Informasi</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                Mempelajari cara merancang, membuat, dan mengelola perangkat lunak (software) dari nol. Cocok bagi Anda yang menyukai logika, coding, dan inovasi teknologi digital.
                            </p>
                            <div class="bg-slate-50 p-5 rounded-2xl">
                                <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Apa yang akan dipelajari:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Pemrograman Web (HTML, CSS, JavaScript, PHP, Framework)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Pengembangan Aplikasi Mobile (Android/iOS)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Manajemen Basis Data (Database MySQL, PostgreSQL)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        UI/UX Design dan Analisis Sistem
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Jurusan 2: TKJ -->
                    <div class="glass-card-pembelajaran rounded-3xl overflow-hidden group hover:border-brand-300 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-4 bg-slate-100 rounded-2xl text-slate-700 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                    <i data-lucide="server" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <h3 class="font-heading text-2xl font-bold text-gray-900">Teknik Komputer & Jaringan</h3>
                                    <p class="text-sm font-medium text-brand-600">Teknologi Informasi</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                Fokus pada perakitan komputer, instalasi jaringan lokal (LAN) hingga area luas (WAN), serta manajemen infrastruktur server dan keamanan siber.
                            </p>
                            <div class="bg-slate-50 p-5 rounded-2xl">
                                <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Apa yang akan dipelajari:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Perakitan & Troubleshooting PC/Laptop
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Instalasi Jaringan Kabel (Fiber Optic) & Nirkabel
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Administrasi Server (Linux/Windows Server)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Konfigurasi Router (MikroTik, Cisco) & Keamanan Jaringan
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Jurusan 3: DKV -->
                    <div class="glass-card-pembelajaran rounded-3xl overflow-hidden group hover:border-brand-300 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-4 bg-slate-100 rounded-2xl text-slate-700 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                    <i data-lucide="monitor-play" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <h3 class="font-heading text-2xl font-bold text-gray-900">Desain Komunikasi Visual</h3>
                                    <p class="text-sm font-medium text-brand-600">Seni dan Ekonomi Kreatif</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                Bagi Anda yang kreatif. Mempelajari bagaimana menyampaikan pesan melalui karya visual, ilustrasi, fotografi, videografi, dan animasi.
                            </p>
                            <div class="bg-slate-50 p-5 rounded-2xl">
                                <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Apa yang akan dipelajari:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Desain Grafis Komersial (Branding, Logo, Poster)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Teknik Fotografi & Videografi Terapan
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Editing Video & Efek Visual (VFX)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Animasi 2D/3D Dasar
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Jurusan 4: TKR -->
                    <div class="glass-card-pembelajaran rounded-3xl overflow-hidden group hover:border-brand-300 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-4 bg-slate-100 rounded-2xl text-slate-700 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                    <i data-lucide="wrench" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <h3 class="font-heading text-2xl font-bold text-gray-900">Teknik Kendaraan Ringan</h3>
                                    <p class="text-sm font-medium text-brand-600">Teknologi Otomotif</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                Mempelajari seluk beluk perawatan, perbaikan, dan analisis mesin mobil/kendaraan ringan, serta kelistrikan standar industri otomotif modern.
                            </p>
                            <div class="bg-slate-50 p-5 rounded-2xl">
                                <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Apa yang akan dipelajari:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Pemeliharaan Mesin Kendaraan Ringan (Engine)
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Sistem Kelistrikan Otomotif & Elektronika Dasar
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Pemeliharaan Sasis dan Pemindah Tenaga
                                    </li>
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-brand-500 shrink-0"></i>
                                        Diagnostic Tools & Teknologi Injeksi (EFI)
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-gradient-to-br from-brand-800 to-brand-900 rounded-3xl p-10 sm:p-14 text-center border border-brand-700 max-w-5xl mx-auto shadow-2xl relative overflow-hidden fade-in-pembelajaran delay-300">
                <!-- Dekoratif Background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full blur-[80px] opacity-20 transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-400 rounded-full blur-[80px] opacity-20 transform -translate-x-1/2 translate-y-1/2"></div>
                
                <div class="relative z-10">
                    <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white mb-6">Siap Mengasah Keahlian Anda Bersama Kami?</h2>
                    <p class="text-brand-100 text-base sm:text-lg mb-8 max-w-2xl mx-auto">
                        Kembangkan bakat, miliki sertifikasi profesi, dan jadilah tenaga kerja terampil yang siap bersaing di dunia kerja maupun siap berwirausaha.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('ppdb') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-brand-900 font-bold bg-white hover:bg-brand-50 rounded-xl transition-all shadow-lg shadow-white/10 hover:-translate-y-1 w-full sm:w-auto justify-center">
                            Daftar PPDB Online
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 text-white font-bold bg-transparent border border-brand-500 hover:bg-brand-700 rounded-xl transition-all w-full sm:w-auto justify-center">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Unduh Brosur
                        </a>
                    </div>
                </div>
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
