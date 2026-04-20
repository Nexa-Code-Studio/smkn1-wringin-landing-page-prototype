@extends('layouts.app')

@section('title', 'Sarana Prasarana - SMKN 1 Wringin')

@section('content')
    @include('partials.navbar')

    <!-- 1. HERO SECTION (CINEMATIC IMMERSIVE) -->
    <section id="home" class="relative pt-20 overflow-hidden flex items-center justify-center h-screen">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Fasilitas SMK" class="w-full h-full object-cover" style="object-position: center 30%;">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-brand/30 to-slate-50"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center flex flex-col items-center">
            <!-- Headline -->
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-6 drop-shadow-2xl">
                Praktek Nyata. <br class="hidden sm:block" /> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-yellow-200">Bukan Sekadar Teori.</span>
            </h1>
            
            <!-- Sub-headline -->
            <p class="text-lg md:text-xl text-slate-200 mb-12 leading-relaxed max-w-3xl mx-auto font-light drop-shadow-md">
                Masuk ke ekosistem belajar berstandar industri. Kami mendesain bengkel, lab, dan studio khusus agar skill-mu langsung <span class="font-bold text-white">matching</span> dengan kebutuhan perusahaan top.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center w-full sm:w-auto">
                <a href="#fasilitas" class="w-full sm:w-auto px-8 py-4 bg-secondary hover:bg-yellow-400 text-slate-900 font-bold rounded-full shadow-[0_0_20px_rgba(245,158,11,0.4)] transition transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg">
                    Lihat Fasilitas <i class="fa-solid fa-arrow-down"></i>
                </a>
                <a href="#" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full border border-white/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg group">
                    <i class="fa-solid fa-play-circle text-2xl group-hover:text-secondary transition-colors"></i> Tonton Video
                </a>
            </div>
        </div>
    </section>

    <!-- 3. FACILITIES GRID (BENTO STYLE) -->
    <section id="fasilitas" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Ruang Aksimu.</h2>
                    <p class="text-slate-500 text-lg md:text-xl max-w-2xl">
                        Intip laboratorium, bengkel, dan area kreatif tempat ide-idemu dieksekusi menjadi mahakarya.
                    </p>
                </div>
            </div>

            <!-- Custom Bento Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 auto-rows-[250px] lg:auto-rows-[280px]">
                
                <!-- 1. Lab RPL / Coding (Tall) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-1 lg:col-span-1 row-span-1 md:row-span-2 lg:row-span-2 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Laboratorium Komputer" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-emerald-400 uppercase mb-2 block drop-shadow-md">Teknologi Informasi</span>
                        <h3 class="text-2xl font-bold text-white leading-tight drop-shadow-lg">High-Spec<br>Coding Lab</h3>
                    </div>
                </div>

                <!-- 2. Bengkel Otomotif (Tall) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-1 lg:col-span-1 row-span-1 md:row-span-2 lg:row-span-2 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1619642751034-765edc748c46?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bengkel Otomotif" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-red-400 uppercase mb-2 block drop-shadow-md">Teknik Mesin</span>
                        <h3 class="text-2xl font-bold text-white leading-tight drop-shadow-lg">Bengkel<br>Auto Pro</h3>
                    </div>
                </div>

                <!-- 3. Studio Broadcasting (Wide) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-2 lg:col-span-2 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1598550476439-6847785fcea6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Studio Broadcasting" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-purple-400 uppercase mb-2 block drop-shadow-md">Multimedia</span>
                        <h3 class="text-2xl font-bold text-white leading-tight drop-shadow-lg">Creative Studio</h3>
                    </div>
                </div>

                <!-- 4. Teaching Factory (Wide) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-2 lg:col-span-2 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Teaching Factory" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-orange-400 uppercase mb-2 block drop-shadow-md">Produksi & Bisnis</span>
                        <h3 class="text-2xl font-bold text-white leading-tight drop-shadow-lg">Teaching Factory</h3>
                    </div>
                </div>

                <!-- 5. Smart Classroom (Square) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-1 lg:col-span-1 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1627556592933-ffe99c1c9cd0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Smart Classroom" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-blue-400 uppercase mb-2 block drop-shadow-md">Teori</span>
                        <h3 class="text-xl font-bold text-white leading-tight drop-shadow-lg">Smart<br>Classroom</h3>
                    </div>
                </div>

                <!-- 6. Perpus/Coworking (Wide) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-1 lg:col-span-2 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1568667256549-094345857637?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Perpustakaan Digital" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-teal-300 uppercase mb-2 block drop-shadow-md">Riset & Diskusi</span>
                        <h3 class="text-2xl font-bold text-white leading-tight drop-shadow-lg">Digi-Library & Hub</h3>
                    </div>
                </div>

                <!-- 7. Kantin Modern (Square) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-2 lg:col-span-1 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Kantin Modern" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-amber-400 uppercase mb-2 block drop-shadow-md">Sosial</span>
                        <h3 class="text-xl font-bold text-white leading-tight drop-shadow-lg">Food Court<br>Kekinian</h3>
                    </div>
                </div>

                <!-- 8. Sport Center (Ultra Wide Bottom Banner) -->
                <div tabindex="0" class="group relative focus:outline-none rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl focus:shadow-xl active:shadow-xl transition-all duration-500 cursor-pointer col-span-1 md:col-span-2 lg:col-span-4 row-span-1 bg-slate-800">
                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Sport Center" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-focus:scale-105 group-active:scale-105" style="object-position: center 30%;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 p-6 lg:p-8 z-10 opacity-0 translate-y-6 group-hover:opacity-100 group-focus:opacity-100 group-active:opacity-100 group-hover:translate-y-0 group-focus:translate-y-0 group-active:translate-y-0 transition-all duration-500 ease-out">
                        <span class="text-[10px] font-bold tracking-widest text-cyan-400 uppercase mb-2 block drop-shadow-md">Kesehatan & Olahraga</span>
                        <h3 class="text-2xl lg:text-3xl font-bold text-white leading-tight drop-shadow-lg">Indoor Sport Arena</h3>
                    </div>
                </div>

            </div>
        </div>
    </section>



    @include('partials.footer')
@endsection
