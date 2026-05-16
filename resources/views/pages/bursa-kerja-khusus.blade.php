@extends('layouts.app')

@section('title', 'Bursa Kerja Khusus (BKK) - SMKN 1 Wringin')

@push('styles')
    <style>
        [x-cloak] { display: none !important; }
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

    @php
        $jobs = [
            [
                'id' => 1,
                'title' => 'Junior Cloud Engineer',
                'company' => 'PT Teknologi Awan Indonesia',
                'type' => 'Full-Time',
                'type_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Jakarta Selatan',
                'major' => 'TKJ / RPL',
                'salary' => 'Gaji Kompetitif',
                'posted_at' => '2 hari lalu',
                'icon' => 'fa-brands fa-aws',
                'icon_bg' => 'bg-blue-50 border-blue-100',
                'icon_color' => 'text-blue-800',
                'description' => 'Kami mencari Junior Cloud Engineer yang bersemangat untuk bergabung dengan tim infrastruktur kami. Anda akan membantu dalam merancang, mengimplementasikan, dan memelihara solusi cloud infrastruktur.',
                'requirements' => [
                    'Lulusan SMK jurusan TKJ atau RPL.',
                    'Memahami konsep dasar komputasi awan (Cloud Computing).',
                    'Familiar dengan sistem operasi Linux dan jaringan dasar.',
                    'Memiliki motivasi tinggi untuk belajar teknologi baru.'
                ]
            ],
            [
                'id' => 2,
                'title' => 'Teknisi Mesin Perakitan',
                'company' => 'PT Otomotif Jaya Makmur',
                'type' => 'Kontrak',
                'type_color' => 'bg-blue-100 text-blue-700',
                'location' => 'Karawang, Jawa Barat',
                'major' => 'Teknik Mesin / TKR',
                'salary' => 'UMR + Lembur',
                'posted_at' => '4 hari lalu',
                'icon' => 'fa-solid fa-car',
                'icon_bg' => 'bg-red-50 border-red-100',
                'icon_color' => 'text-red-600',
                'description' => 'Dibutuhkan teknisi yang handal untuk bagian perakitan komponen otomotif. Anda akan bekerja di lingkungan pabrik dengan standar keamanan dan kualitas yang tinggi.',
                'requirements' => [
                    'Lulusan SMK jurusan Teknik Mesin atau TKR.',
                    'Mampu membaca gambar teknik dan menggunakan alat ukur presisi.',
                    'Bersedia bekerja dalam sistem shift.',
                    'Disiplin, teliti, dan sehat jasmani.'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Staff Administrasi & Pajak',
                'company' => 'KAP Sudirman & Rekan',
                'type' => 'Full-Time',
                'type_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Surabaya, Jawa Timur',
                'major' => 'Akuntansi / Administrasi',
                'salary' => 'Gaji Kompetitif',
                'posted_at' => '1 minggu lalu',
                'icon' => 'fa-solid fa-calculator',
                'icon_bg' => 'bg-slate-100 border-slate-200',
                'icon_color' => 'text-slate-700',
                'description' => 'Kami membuka kesempatan bagi tenaga administrasi muda untuk mendukung operasional kantor akuntan publik. Tanggung jawab meliputi pengelolaan dokumen pajak dan laporan keuangan dasar.',
                'requirements' => [
                    'Lulusan SMK jurusan Akuntansi atau Administrasi Perkantoran.',
                    'Menguasai Microsoft Office (terutama Excel).',
                    'Memiliki ketelitian tinggi dalam pengolahan data angka.',
                    'Memahami dasar-dasar perpajakan menjadi nilai tambah.'
                ]
            ]
        ];
    @endphp

    <div x-data="{ modalOpen: false, activeJob: null }" class="min-h-screen bg-slate-50 pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
                <div>
                    <span class="text-brand font-bold tracking-wider uppercase text-sm mb-2 block">Bursa Kerja Khusus</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">Lowongan Kerja</h1>
                    <p class="text-slate-500 max-w-2xl">Peluang karir menantimu dari berbagai mitra industri kami. Temukan pekerjaan yang sesuai dengan keahlianmu.</p>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 mb-10 flex flex-col md:flex-row gap-4 shadow-sm">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Cari posisi atau nama perusahaan..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand transition-all bg-slate-50">
                </div>
                <div class="md:w-64 relative">
                    <i class="fa-solid fa-graduation-cap absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand/50 appearance-none bg-slate-50 transition-all">
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
                    <select class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand/50 appearance-none bg-slate-50 transition-all">
                        <option value="">Semua Lokasi</option>
                        <option value="jakarta">Jakarta Raya</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="bandung">Bandung</option>
                        <option value="batam">Batam</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                <button class="bg-brand text-white px-8 py-3 rounded-xl font-bold hover:bg-brand-700 transition-colors shadow-md shadow-brand/20 whitespace-nowrap">
                    Cari
                </button>
            </div>

            <!-- Job Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($jobs as $job)
                    <div 
                        @click="activeJob = {{ Js::from($job) }}; modalOpen = true"
                        class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl hover:border-brand/30 transition-all duration-300 flex flex-col h-full group cursor-pointer"
                    >
                        <div class="flex justify-between items-start mb-5">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center border p-2 {{ $job['icon_bg'] }}">
                                <i class="{{ $job['icon'] }} text-3xl {{ $job['icon_color'] }}"></i>
                            </div>
                            <span class="{{ $job['type_color'] }} text-xs font-bold px-3 py-1 rounded-full">{{ $job['type'] }}</span>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800 group-hover:text-brand transition-colors mb-1">{{ $job['title'] }}</h3>
                        <p class="text-slate-500 font-medium mb-6 text-sm">{{ $job['company'] }}</p>
                        
                        <div class="space-y-3 mb-6 flex-grow">
                            <div class="flex items-center text-sm text-slate-600">
                                <div class="w-6 flex justify-center"><i class="fa-solid fa-location-dot text-slate-400"></i></div>
                                <span>{{ $job['location'] }}</span>
                            </div>
                            <div class="flex items-center text-sm text-slate-600">
                                <div class="w-6 flex justify-center"><i class="fa-solid fa-graduation-cap text-slate-400"></i></div>
                                <span>{{ $job['major'] }}</span>
                            </div>
                            <div class="flex items-center text-sm text-slate-600">
                                <div class="w-6 flex justify-center"><i class="fa-solid fa-money-bill-wave text-slate-400"></i></div>
                                <span>{{ $job['salary'] }}</span>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-xs text-slate-400 font-medium"><i class="fa-regular fa-clock mr-1"></i> {{ $job['posted_at'] }}</span>
                            <span class="text-brand font-bold text-sm group-hover:text-brand-700 transition-colors flex items-center gap-1">Lihat Detail <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Job Detail Modal -->
            <template x-teleport="body">
                <div 
                    x-show="modalOpen" 
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                    x-cloak
                >
                    <!-- Backdrop -->
                    <div 
                        x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                        @click="modalOpen = false"
                    ></div>

                    <!-- Modal Panel -->
                    <div 
                        x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
                    >
                        <!-- Modal Header -->
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white/95 backdrop-blur z-10">
                            <div class="flex items-center gap-4">
                                <div :class="['w-12 h-12 rounded-xl flex items-center justify-center border p-2', activeJob?.icon_bg]">
                                    <i :class="[activeJob?.icon, activeJob?.icon_color, 'text-2xl']"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900" x-text="activeJob?.title"></h3>
                                    <p class="text-brand font-semibold text-sm" x-text="activeJob?.company"></p>
                                </div>
                            </div>
                            <button 
                                @click="modalOpen = false"
                                class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-full transition-colors focus:outline-none"
                            >
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 overflow-y-auto hide-scrollbar">
                            <div class="flex flex-wrap gap-2 mb-8">
                                <span :class="[activeJob?.type_color, 'text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5']">
                                    <i class="fa-solid fa-briefcase"></i> <span x-text="activeJob?.type"></span>
                                </span>
                                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot"></i> <span x-text="activeJob?.location"></span>
                                </span>
                                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <i class="fa-solid fa-money-bill-wave"></i> <span x-text="activeJob?.salary"></span>
                                </span>
                            </div>

                            <div class="space-y-8 text-slate-600">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-align-left text-brand"></i> Deskripsi Pekerjaan
                                    </h4>
                                    <p class="leading-relaxed text-sm" x-text="activeJob?.description"></p>
                                </div>

                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-list-check text-brand"></i> Persyaratan
                                    </h4>
                                    <ul class="space-y-2">
                                        <template x-for="(req, index) in activeJob?.requirements" :key="index">
                                            <li class="flex items-start gap-3 text-sm">
                                                <i class="fa-solid fa-check text-emerald-500 mt-1"></i>
                                                <span x-text="req" class="leading-relaxed"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="px-6 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                            <button 
                                @click="modalOpen = false"
                                class="px-6 py-2.5 rounded-xl font-bold text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition-colors"
                            >
                                Tutup
                            </button>
                            <button 
                                class="px-8 py-2.5 rounded-xl font-bold bg-brand text-white hover:bg-brand-700 shadow-md shadow-brand/20 transition-colors flex items-center gap-2"
                            >
                                Lamar Sekarang <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @include('partials.footer')
@endsection
