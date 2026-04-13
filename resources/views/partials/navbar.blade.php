{{-- NAVIGATION --}}
<nav x-data="{ mobileOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'shadow-md bg-white/90' : 'bg-white/95'"
    class="fixed w-full z-50 backdrop-blur-md border-b border-slate-200 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xl text-slate-800 leading-none">SMKN 1 <span
                            class="text-brand-600">Wringin</span></span>
                    <span class="text-xs text-slate-500 font-medium tracking-wider">VOCATIONAL SCHOOL</span>
                </div>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home" class="text-slate-600 hover:text-brand-600 font-medium transition">Beranda</a>
                <a href="#jurusan" class="text-slate-600 hover:text-brand-600 font-medium transition">Kompetensi
                    Keahlian</a>
                <a href="#profil" class="text-slate-600 hover:text-brand-600 font-medium transition">Profil</a>
                <a href="#berita" class="text-slate-600 hover:text-brand-600 font-medium transition">Berita</a>
                <a href="#ppdb"
                    class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition shadow-lg shadow-brand-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-file-pen"></i> Info PPDB
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden flex items-center">
                <button @click="mobileOpen = !mobileOpen"
                    class="text-slate-600 hover:text-brand-600 focus:outline-none p-2" id="mobile-menu-btn">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Panel --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white border-t border-slate-100 absolute w-full shadow-xl" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a @click="mobileOpen = false" href="#home"
                class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Beranda</a>
            <a @click="mobileOpen = false" href="#jurusan"
                class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Jurusan</a>
            <a @click="mobileOpen = false" href="#profil"
                class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Profil
                Sekolah</a>
            <a @click="mobileOpen = false" href="#berita"
                class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Berita
                Terkini</a>
            <a @click="mobileOpen = false" href="#ppdb"
                class="block px-3 py-3 text-brand-600 font-bold bg-brand-50 mt-2 rounded-md text-center">Info PPDB
                Online</a>
        </div>
    </div>
</nav>