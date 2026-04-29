@extends('layouts.app')

@section('title', 'Bursa Kerja Khusus (BKK) - SMKN 1 Wringin')

@push('styles')
    <style>
        /* Custom Scrollbar for job filters */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <!-- 1. HERO SECTION -->
    <section id="home" class="relative h-[100svh] min-h-[600px] lg:min-h-0 overflow-hidden flex items-center pt-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Profesional Muda" class="w-full h-full object-cover" style="object-position: center 20%;">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/70 to-brand/40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full flex flex-col items-start pt-12 pb-12 lg:pt-0 lg:pb-0">
            <!-- Headline -->
            <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-tight mb-4 max-w-4xl drop-shadow-2xl">
                Siap Kerja Setelah Lulus. <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-yellow-200">Karir Impian Dimulai di Sini.</span>
            </h1>
            
            <!-- Sub-headline -->
            <p class="text-lg md:text-xl text-slate-200 mb-10 leading-relaxed max-w-2xl font-light drop-shadow-md">
                Bursa Kerja Khusus (BKK) SMK Nusantara menjembatani kompetensi unggul siswa dan alumni dengan jaringan industri serta perusahaan berskala nasional maupun multinasional.
            </p>
            
            <div class="flex flex-col w-full max-w-4xl">
                <!-- CTA Buttons -->
                <div class="order-1 flex flex-col sm:flex-row gap-4 mb-8 lg:mb-10">
                    <a href="#lowongan" class="w-full sm:w-auto px-8 py-3.5 bg-secondary hover:bg-yellow-400 text-slate-900 font-bold rounded-full shadow-[0_0_20px_rgba(245,158,11,0.4)] transition transform focus:outline-none flex items-center justify-center gap-2 text-base">
                        Info Lowongan
                    </a>
                    <a href="#daftar" class="w-full sm:w-auto px-8 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold rounded-full transition focus:outline-none flex items-center justify-center gap-2 text-base group">
                        <i class="fa-solid fa-book-open group-hover:scale-110 transition"></i> Daftar Sekarang
                    </a>
                </div>

                <!-- Statistik -->
                <div class="order-2 grid grid-cols-3 gap-6 sm:gap-4 border-t border-white/20 pt-6 w-full max-w-2xl">
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">85<span class="text-secondary">%</span></p>
                        <p class="text-[10px] lg:text-xs text-slate-300 font-medium whitespace-nowrap uppercase tracking-wider mt-1">Alumni Terserap</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">120<span class="text-secondary">+</span></p>
                        <p class="text-[10px] lg:text-xs text-slate-300 font-medium whitespace-nowrap uppercase tracking-wider mt-1">Mitra Perusahaan</p>
                    </div>
                    <div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-white">45<span class="text-secondary">+</span></p>
                        <p class="text-[10px] lg:text-xs text-slate-300 font-medium whitespace-nowrap uppercase tracking-wider mt-1">Lowongan Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- 3. ALUR PENDAFTARAN -->
    <section id="alur" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-brand font-bold tracking-wider uppercase text-sm mb-2 block">Langkah Mudah</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Cara Melamar Pekerjaan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Kami mempermudah proses rekrutmen. Ikuti langkah sederhana ini untuk terhubung dengan perusahaan impianmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line (Desktop only) -->
                <div class="hidden md:block absolute top-12 left-[10%] right-[10%] h-0.5 bg-slate-200 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-24 h-24 rounded-full bg-white border-4 border-brand shadow-lg flex items-center justify-center text-3xl text-brand group-hover:scale-110 group-hover:bg-brand group-hover:text-white transition-all duration-300 mb-6">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">1. Daftar Akun</h3>
                    <p class="text-sm text-slate-500">Gunakan NISN atau email alumni untuk mendaftar di portal BKK.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-24 h-24 rounded-full bg-white border-4 border-slate-200 shadow-lg flex items-center justify-center text-3xl text-slate-400 group-hover:border-brand group-hover:scale-110 group-hover:bg-brand group-hover:text-white transition-all duration-300 mb-6">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">2. Lengkapi Profil</h3>
                    <p class="text-sm text-slate-500">Isi data diri, unggah CV terbaru, dan masukkan portofolio keahlianmu.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-24 h-24 rounded-full bg-white border-4 border-slate-200 shadow-lg flex items-center justify-center text-3xl text-slate-400 group-hover:border-brand group-hover:scale-110 group-hover:bg-brand group-hover:text-white transition-all duration-300 mb-6">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">3. Lamar Pekerjaan</h3>
                    <p class="text-sm text-slate-500">Cari lowongan yang sesuai dengan kompetensi jurusanmu dan klik Lamar.</p>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-24 h-24 rounded-full bg-white border-4 border-slate-200 shadow-lg flex items-center justify-center text-3xl text-slate-400 group-hover:border-brand group-hover:scale-110 group-hover:bg-brand group-hover:text-white transition-all duration-300 mb-6">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">4. Ikuti Seleksi</h3>
                    <p class="text-sm text-slate-500">Pantau status lamaranmu dan ikuti tahapan tes atau wawancara.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. DAFTAR LOWONGAN KERJA -->
    <section id="lowongan" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Lowongan Kerja Terbaru</h2>
                    <p class="text-slate-500">Peluang karir menantimu dari berbagai mitra industri kami.</p>
                </div>
                <a href="#" class="text-brand font-semibold hover:text-brand-700 flex items-center gap-2">
                    Lihat Semua Lowongan <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Filter Section -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 mb-10 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Cari posisi atau nama perusahaan..." class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand">
                </div>
                <div class="md:w-64 relative">
                    <i class="fa-solid fa-graduation-cap absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/50 appearance-none bg-white">
                        <option value="">Semua Jurusan</option>
                        <option value="tkj">Teknik Komputer & Jaringan</option>
                        <option value="rpl">Rekayasa Perangkat Lunak</option>
                        <option value="tkr">Teknik Kendaraan Ringan</option>
                        <option value="ak">Akuntansi</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                <div class="md:w-64 relative">
                    <i class="fa-solid fa-location-dot absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/50 appearance-none bg-white">
                        <option value="">Semua Lokasi</option>
                        <option value="jakarta">Jakarta Raya</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="bandung">Bandung</option>
                        <option value="batam">Batam</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                <button class="bg-brand text-white px-6 py-3 rounded-lg font-semibold hover:bg-brand-700 transition">
                    Cari
                </button>
            </div>

            <!-- Job Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Job Card 1 -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl transition-shadow duration-300 flex flex-col h-full group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 p-2">
                            <i class="fa-brands fa-aws text-3xl text-blue-800"></i>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Full-Time</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-brand transition-colors">Junior Cloud Engineer</h3>
                    <p class="text-slate-500 font-medium mb-4">PT Teknologi Awan Indonesia</p>
                    
                    <div class="space-y-2 mb-6 flex-grow">
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-location-dot w-5 text-slate-400"></i> Jakarta Selatan
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-graduation-cap w-5 text-slate-400"></i> TKJ / RPL
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-money-bill-wave w-5 text-slate-400"></i> Gaji Kompetitif
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs text-slate-400"><i class="fa-regular fa-clock"></i> Diposting 2 hari lalu</span>
                        <a href="#" class="text-brand font-semibold text-sm hover:text-secondary transition">Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>

                <!-- Job Card 2 -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl transition-shadow duration-300 flex flex-col h-full group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center border border-red-100 p-2">
                            <i class="fa-solid fa-car text-3xl text-red-600"></i>
                        </div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Kontrak</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-brand transition-colors">Teknisi Mesin Perakitan</h3>
                    <p class="text-slate-500 font-medium mb-4">PT Otomotif Jaya Makmur</p>
                    
                    <div class="space-y-2 mb-6 flex-grow">
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-location-dot w-5 text-slate-400"></i> Karawang, Jawa Barat
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-graduation-cap w-5 text-slate-400"></i> Teknik Mesin / TKR
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-money-bill-wave w-5 text-slate-400"></i> UMR + Lembur
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs text-slate-400"><i class="fa-regular fa-clock"></i> Diposting 4 hari lalu</span>
                        <a href="#" class="text-brand font-semibold text-sm hover:text-secondary transition">Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>

                <!-- Job Card 3 -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl transition-shadow duration-300 flex flex-col h-full group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center border border-slate-200 p-2">
                            <i class="fa-solid fa-calculator text-3xl text-slate-700"></i>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Full-Time</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-brand transition-colors">Staff Administrasi & Pajak</h3>
                    <p class="text-slate-500 font-medium mb-4">KAP Sudirman & Rekan</p>
                    
                    <div class="space-y-2 mb-6 flex-grow">
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-location-dot w-5 text-slate-400"></i> Surabaya, Jawa Timur
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-graduation-cap w-5 text-slate-400"></i> Akuntansi / Administrasi
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <i class="fa-solid fa-money-bill-wave w-5 text-slate-400"></i> Gaji Kompetitif
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs text-slate-400"><i class="fa-regular fa-clock"></i> Diposting 1 minggu lalu</span>
                        <a href="#" class="text-brand font-semibold text-sm hover:text-secondary transition">Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <button class="px-8 py-3 bg-white border-2 border-brand text-brand font-bold rounded-full hover:bg-brand hover:text-white transition-colors duration-300">
                    Muat Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    <!-- 5. TESTIMONI ALUMNI -->
    <section id="testimoni" class="py-24 bg-brand relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full border-8 border-white/10 opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-white/5 opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kisah Sukses Alumni</h2>
                <p class="text-brand-100 max-w-2xl mx-auto">Mendengar langsung pengalaman mereka yang telah membuktikan kualitas penyaluran kerja SMK Nusantara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 relative">
                    <i class="fa-solid fa-quote-left absolute top-6 right-6 text-4xl text-white/20"></i>
                    <p class="text-slate-100 mb-6 italic leading-relaxed relative z-10">
                        "Berkat BKK SMK Nusantara, saya mendapat pendampingan membuat CV hingga simulasi interview. Sebulan sebelum wisuda, saya sudah diterima bekerja."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Budi Santoso" class="w-14 h-14 rounded-full object-cover border-2 border-secondary">
                        <div>
                            <h4 class="text-white font-bold">Budi Santoso</h4>
                            <p class="text-brand-100 text-xs">Teknisi Mesin, PT Astra Motor</p>
                            <p class="text-secondary text-xs mt-1 font-semibold">Alumni TKR (2023)</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 relative">
                    <i class="fa-solid fa-quote-left absolute top-6 right-6 text-4xl text-white/20"></i>
                    <p class="text-slate-100 mb-6 italic leading-relaxed relative z-10">
                        "Skill coding saya yang diasah selama di SMK ternyata sangat relevan dengan kebutuhan industri. Portal lowongan BKK ini sangat memudahkan alumni."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Siti Aminah" class="w-14 h-14 rounded-full object-cover border-2 border-secondary">
                        <div>
                            <h4 class="text-white font-bold">Siti Aminah</h4>
                            <p class="text-brand-100 text-xs">Junior Programmer, TechIndo</p>
                            <p class="text-secondary text-xs mt-1 font-semibold">Alumni RPL (2022)</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 relative md:col-span-2 lg:col-span-1">
                    <i class="fa-solid fa-quote-left absolute top-6 right-6 text-4xl text-white/20"></i>
                    <p class="text-slate-100 mb-6 italic leading-relaxed relative z-10">
                        "Informasi lowongannya selalu update. Sistem penyaluran kerjanya sangat terstruktur dan transparan."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Andi Wijaya" class="w-14 h-14 rounded-full object-cover border-2 border-secondary">
                        <div>
                            <h4 class="text-white font-bold">Andi Wijaya</h4>
                            <p class="text-brand-100 text-xs">Admin Pajak, KAP Sudirman</p>
                            <p class="text-secondary text-xs mt-1 font-semibold">Alumni Akuntansi (2023)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. FINAL CALL TO ACTION -->
    <section class="py-24 bg-white relative overflow-hidden text-center border-t-4 border-secondary">
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="w-20 h-20 bg-brand/10 rounded-full flex items-center justify-center text-brand text-4xl mx-auto mb-6">
                <i class="fa-solid fa-rocket"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Mulai Karirmu Sekarang!</h2>
            <p class="text-slate-500 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                Ratusan peluang emas sedang menunggu kandidat terbaik. Jangan lewatkan kesempatan untuk bergabung dengan perusahaan terkemuka.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#daftar" class="inline-flex items-center justify-center gap-3 px-10 py-4 bg-brand text-white font-bold rounded-full shadow-lg hover:bg-brand-700 transition transform hover:-translate-y-1 text-lg">
                    Daftar Sebagai Pencari Kerja
                </a>
                <a href="#mitra" class="inline-flex items-center justify-center gap-3 px-10 py-4 bg-white text-slate-800 font-bold rounded-full border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition transform hover:-translate-y-1 text-lg">
                    Login BKK <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
