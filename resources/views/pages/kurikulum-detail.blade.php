@extends('layouts.app')

@section('title', 'Rekayasa Perangkat Lunak - SMKN 1 Wringin')

@section('content')
    @include('partials.navbar')

    {{-- HEADER / HERO DETAIL JURUSAN --}}
    <section class="min-h-screen pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-600 relative overflow-hidden text-white flex items-center">
        {{-- Background Elements --}}
        <div class="absolute inset-0 opacity-10 bg-grid-pattern"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl -mr-20 -mt-20"></div>
        
        {{-- Decoration Circles --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 border-[40px] border-white/5 rounded-full pointer-events-none animate-[pulse_8s_infinite]"></div>
        <div class="absolute bottom-0 left-1/4 w-64 h-64 border-[20px] border-white/5 rounded-full -mb-32 pointer-events-none animate-[pulse_6s_infinite]"></div>
        <div class="absolute top-20 right-20 w-48 h-48 border-[12px] border-white/5 rounded-full pointer-events-none animate-[pulse_10s_infinite]"></div>
        <div class="absolute top-1/2 left-10 w-24 h-24 border-8 border-white/10 rounded-full pointer-events-none opacity-50 animate-[bounce_5s_infinite]"></div>
        <div class="absolute -bottom-10 right-1/3 w-72 h-72 border-[30px] border-white/5 rounded-full pointer-events-none animate-[pulse_7s_infinite]"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 border-2 border-white/20 rounded-full pointer-events-none opacity-70"></div>
        <div class="absolute bottom-10 right-10 w-16 h-16 border-4 border-white/10 rounded-full pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center lg:text-left flex flex-col lg:flex-row-reverse items-center gap-12 w-full">
            
            {{-- Hero Image - Now first in HTML to show on top in Mobile --}}
            <div data-animate="fade-left" data-delay="400" class="w-2/3 max-w-[280px] mx-auto lg:mx-0 lg:max-w-none lg:w-1/3 relative">
                <div class="aspect-square rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 p-4 shadow-2xl relative overflow-hidden flex items-center justify-center group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-600/20 to-transparent"></div>
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Coding" class="w-full h-full object-cover rounded-2xl shadow-inner z-10 transform group-hover:scale-105 transition duration-700">
                    
                    {{-- Decorative elements over image --}}
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-secondary-500 rounded-full blur-2xl opacity-50"></div>
                </div>
            </div>

            {{-- Text Content --}}
            <div class="flex-1">
                <h1 data-animate="fade-up" data-delay="100" class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6 break-words">
                    Rekayasa Perangkat Lunak
                </h1>
                <p data-animate="fade-up" data-delay="200" class="text-lg text-brand-50 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Mencetak programmer dan developer handal yang siap menghadapi tantangan industri digital 4.0. Pelajari pembuatan web, aplikasi mobile, hingga manajemen basis data dengan kurikulum berstandar industri.
                </p>
                <div data-animate="fade-up" data-delay="300" class="flex justify-center lg:justify-start">
                    <a href="#deskripsi" class="group flex items-center gap-2 text-secondary-400 font-semibold hover:text-white transition">
                        Selengkapnya 
                        <i class="fa-solid fa-arrow-down group-hover:translate-y-1 transition group-hover:animate-bounce"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- DESKRIPSI & INFO SINGKAT --}}
    <section id="deskripsi" class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">
                
                {{-- Main Content / Deskripsi --}}
                <div class="lg:col-span-2" data-animate="fade-right">
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-1 bg-brand-600 rounded-full"></span>
                        Mengenal Jurusan RPL
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed space-y-4">
                        <p>
                            Rekayasa Perangkat Lunak (RPL) atau <i>Software Engineering</i> adalah satu bidang profesi yang mendalami cara-cara pengembangan perangkat lunak termasuk pembuatan, pemeliharaan, manajemen organisasi pengembangan perangkat lunak dan manajemen kualitas.
                        </p>
                        <p>
                            Di SMKN 1 Wringin, jurusan RPL tidak hanya belajar sebatas teori, melainkan lebih banyak melakukan praktik langsung (Project Based Learning). Siswa akan dibekali dengan bahasa pemrograman modern seperti HTML/CSS, JavaScript, PHP, Python, hingga pengembangan aplikasi berbasis mobile (Android/iOS).
                        </p>
                        <p>
                            Lulusan dari program keahlian ini memiliki prospek kerja yang sangat luas di berbagai perusahaan teknologi, startup, instansi pemerintahan, atau bahkan menjadi seorang <i>technopreneur</i> (pengusaha di bidang teknologi) mandiri.
                        </p>
                    </div>
                </div>

                {{-- Sidebar / Quick Facts --}}
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 shadow-sm h-fit" data-animate="fade-left" data-delay="200">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-200 pb-4">Info Program Keahlian</h3>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4 group">
                            <div class="w-10 h-10 bg-brand-600/10 rounded-full flex items-center justify-center text-brand-600 flex-shrink-0 group-hover:bg-brand-600 group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Masa Studi</p>
                                <p class="font-bold text-slate-800">3 Tahun</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-10 h-10 bg-brand-600/10 rounded-full flex items-center justify-center text-brand-600 flex-shrink-0 group-hover:bg-brand-600 group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Kompetensi Utama</p>
                                <p class="font-bold text-slate-800">Web & Mobile Development</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-10 h-10 bg-brand-600/10 rounded-full flex items-center justify-center text-brand-600 flex-shrink-0 group-hover:bg-brand-600 group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-building-circle-check"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Mitra Industri (Prakerin)</p>
                                <p class="font-bold text-slate-800">Telkom, Dicoding, Tech Startup</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- KEUNGGULAN PROGRAM --}}
    <section class="py-20 bg-slate-50 border-y border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-animate="fade-up">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Nilai Tambah</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900">Keunggulan RPL SMKN 1 Wringin</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Keunggulan 1 --}}
                <div data-animate="fade-up" data-delay="100" class="bg-white p-8 rounded-2xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out group">
                    <div class="w-14 h-14 bg-brand-600/10 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition duration-500">
                        <i class="fa-solid fa-book-bookmark text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-3">Kurikulum Industri</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Materi pembelajaran selalu di-update menyesuaikan dengan teknologi terbaru yang sedang dipakai oleh perusahaan tech saat ini.</p>
                </div>

                {{-- Keunggulan 2 --}}
                <div data-animate="fade-up" data-delay="200" class="bg-white p-8 rounded-2xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out group">
                    <div class="w-14 h-14 bg-brand-600/10 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition duration-500">
                        <i class="fa-solid fa-server text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-3">Laboratorium Modern</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Dilengkapi dengan 3 Lab Komputer spesifikasi tinggi (Core i7, RAM 16GB), jaringan fiber optik, dan server lokal untuk praktik.</p>
                </div>

                {{-- Keunggulan 3 --}}
                <div data-animate="fade-up" data-delay="300" class="bg-white p-8 rounded-2xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out group">
                    <div class="w-14 h-14 bg-brand-600/10 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition duration-500">
                        <i class="fa-solid fa-certificate text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-3">Sertifikasi BNSP</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Siswa yang lulus akan diikutsertakan dalam uji kompetensi keahlian dan mendapatkan sertifikat resmi dari BNSP.</p>
                </div>

                {{-- Keunggulan 4 --}}
                <div data-animate="fade-up" data-delay="400" class="bg-white p-8 rounded-2xl border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out group">
                    <div class="w-14 h-14 bg-brand-600/10 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition duration-500">
                        <i class="fa-solid fa-rocket text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-3">Teaching Factory</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Siswa mengerjakan proyek nyata dari klien (website sekolah, aplikasi kasir, dll) untuk melatih jiwa entrepreneur.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- GALERI / FOTO PROGRAM --}}
    <section class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0 mb-16" data-animate="fade-up">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Fasilitas & Kegiatan</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900">Galeri Jurusan RPL</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                {{-- Foto 1 (Besar) --}}
                <div data-animate="zoom-in" class="col-span-2 md:col-span-2 row-span-2 relative group overflow-hidden rounded-2xl h-64 md:h-full shadow-lg">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Siswa berdiskusi proyek" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-6">
                        <span class="text-white font-semibold text-lg">Diskusi Proyek Tim (Scrum)</span>
                    </div>
                </div>

                <div data-animate="zoom-in" data-delay="100" class="relative group overflow-hidden rounded-2xl h-48 md:h-64 shadow-md">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Menulis Kode" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white font-medium text-sm">Praktik Koding</span>
                    </div>
                </div>

                <div data-animate="zoom-in" data-delay="200" class="relative group overflow-hidden rounded-2xl h-48 md:h-64 shadow-md">
                    <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Lab Komputer" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white font-medium text-sm">Lab Komputer Modern</span>
                    </div>
                </div>

                <div data-animate="zoom-in" data-delay="300" class="relative group overflow-hidden rounded-2xl h-48 md:h-64 shadow-md">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Jaringan Server" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white font-medium text-sm">Manajemen Server</span>
                    </div>
                </div>

                <div data-animate="zoom-in" data-delay="400" class="relative group overflow-hidden rounded-2xl h-48 md:h-64 shadow-md">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Kunjungan Industri" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white font-medium text-sm">Kunjungan Industri Tech</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
