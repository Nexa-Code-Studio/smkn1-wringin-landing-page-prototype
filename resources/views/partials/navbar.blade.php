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
                    <span class="text-xs text-slate-500 font-medium tracking-wider uppercase">Vocational School</span>
                </div>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex space-x-6 items-center">
                {{-- Beranda --}}
                <a href="#home" class="text-slate-600 hover:text-brand-600 font-medium transition">Beranda</a>

                {{-- Kurikulum Dropdown --}}
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center gap-1 text-slate-600 hover:text-brand-600 font-medium transition">
                        Kurikulum <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        class="absolute top-full left-0 w-48 bg-white rounded-lg shadow-xl py-2 mt-0 border border-slate-100">
                        <a href="#profil-jurusan" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Profile Jurusan</a>
                        <a href="#pembelajaran" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Pembelajaran</a>
                    </div>
                </div>

                {{-- Kesiswaan Dropdown --}}
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center gap-1 text-slate-600 hover:text-brand-600 font-medium transition">
                        Kesiswaan <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        class="absolute top-full left-0 w-48 bg-white rounded-lg shadow-xl py-2 mt-0 border border-slate-100">
                        <a href="{{ route('budaya.positif') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Budaya Positif</a>
                        <a href="{{ route('ekstrakurikuler') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Ekstrakurikuler</a>
                        <a href="{{ route('ppdb') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">PPDB</a>
                    </div>
                </div>

                {{-- Sarana Prasarana --}}
                <a href="{{ route('sarana.prasarana') }}" class="text-slate-600 hover:text-brand-600 font-medium transition">Sarana Prasarana</a>

                {{-- Humas Dropdown --}}
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center gap-1 text-slate-600 hover:text-brand-600 font-medium transition">
                        Humas <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        class="absolute top-full left-0 w-48 bg-white rounded-lg shadow-xl py-2 mt-0 border border-slate-100">
                        <a href="{{ route('bursa.kerja.khusus') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Bursa Kerja Khusus</a>
                        <a href="#kemitraan" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">Kemitraan</a>
                    </div>
                </div>

                {{-- Berita --}}
                <a href="#berita" class="text-slate-600 hover:text-brand-600 font-medium transition">Berita</a>

                <a href="{{ route('ppdb') }}"
                    class="ml-4 px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full transition shadow-lg shadow-brand-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-file-pen"></i> Info PPDB
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="lg:hidden flex items-center">
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
        class="lg:hidden bg-white border-t border-slate-100 absolute w-full shadow-xl" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="#home" @click="mobileOpen = false" class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Beranda</a>
            
            {{-- Kurikulum (Accordion) --}}
            <div x-data="{ extra: false }">
                <button @click="extra = !extra" class="w-full flex justify-between items-center px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">
                    Kurikulum <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="extra ? 'rotate-180' : ''"></i>
                </button>
                <div class="grid transition-[grid-template-rows] duration-300 ease-in-out" :class="extra ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <div class="overflow-hidden bg-slate-50 rounded-md">
                        <a href="#profil-jurusan" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition border-b border-white/50">Profile Jurusan</a>
                        <a href="#pembelajaran" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition">Pembelajaran</a>
                    </div>
                </div>
            </div>

            {{-- Kesiswaan (Accordion) --}}
            <div x-data="{ extra: false }">
                <button @click="extra = !extra" class="w-full flex justify-between items-center px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">
                    Kesiswaan <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="extra ? 'rotate-180' : ''"></i>
                </button>
                <div class="grid transition-[grid-template-rows] duration-300 ease-in-out" :class="extra ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <div class="overflow-hidden bg-slate-50 rounded-md">
                        <a href="{{ route('budaya.positif') }}" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition border-b border-white/50">Budaya Positif</a>
                        <a href="{{ route('ekstrakurikuler') }}" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition border-b border-white/50">Ekstrakurikuler</a>
                        <a href="{{ route('ppdb') }}" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition">PPDB</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('sarana.prasarana') }}" @click="mobileOpen = false" class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Sarana Prasarana</a>

            {{-- Humas (Accordion) --}}
            <div x-data="{ extra: false }">
                <button @click="extra = !extra" class="w-full flex justify-between items-center px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">
                    Humas <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="extra ? 'rotate-180' : ''"></i>
                </button>
                <div class="grid transition-[grid-template-rows] duration-300 ease-in-out" :class="extra ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                    <div class="overflow-hidden bg-slate-50 rounded-md">
                        <a href="{{ route('bursa.kerja.khusus') }}" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition border-b border-white/50">Bursa Kerja Khusus</a>
                        <a href="#kemitraan" @click="mobileOpen = false" class="block px-8 py-2.5 text-sm text-slate-600 hover:text-brand-600 transition">Kemitraan</a>
                    </div>
                </div>
            </div>

            <a href="#berita" @click="mobileOpen = false" class="block px-3 py-3 text-slate-600 font-medium hover:bg-slate-50 hover:text-brand-600 rounded-md border-b border-slate-50">Berita</a>

            <a href="{{ route('ppdb') }}" @click="mobileOpen = false"
                class="block px-3 py-3 text-brand-600 font-bold bg-brand-50 mt-2 rounded-md text-center">Info PPDB Online</a>
        </div>
    </div>
</nav>