@extends('layouts.app')

@section('title', 'Informasi PPDB - SMKN 1 Wringin')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1E5460 0%, #132e35 100%);
    }
    
    /* Typography for reading (Medium style) */
    .article-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        color: #334155; /* slate-700 */
        font-size: 1.125rem; /* text-lg */
    }
    .article-content h2 {
        font-size: 1.875rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 3rem;
        margin-bottom: 1rem;
    }
    .article-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
        color: #334155;
        font-size: 1.125rem;
        line-height: 1.8;
    }
    .article-content li {
        margin-bottom: 0.5rem;
    }

    /* --- ADMIN MODE STYLES --- */
    .content-block {
        position: relative;
        border: 2px solid transparent;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .admin-controls {
        display: none;
        position: absolute;
        top: -15px;
        right: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 10;
        overflow: hidden;
    }

    .add-block-btn {
        display: none;
        width: 100%;
        height: 20px;
        position: relative;
        margin: 0.5rem 0;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .add-block-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #1E5460;
        z-index: 1;
    }
    .add-block-btn-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #1E5460;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        font-size: 12px;
    }

    /* Active Admin Mode */
    body.is-admin .content-block {
        border: 2px dashed #cbd5e1;
        padding: 1rem -0.5rem;
        margin: 0.5rem -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    body.is-admin .content-block:hover {
        border-color: #1E5460;
        background-color: #f0f9fa;
    }
    body.is-admin .content-block:hover .admin-controls {
        display: flex;
    }
    body.is-admin .add-block-btn {
        display: block;
    }
    body.is-admin .add-block-btn:hover {
        opacity: 1;
    }

    /* Toggle Switch */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #f59e0b;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #f59e0b;
    }
</style>
@endpush

@section('content')
    @include('partials.navbar')

    {{-- Header / Hero Section --}}
    <header class="pt-32 pb-10 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            {{-- Admin Mode Toggle (Optional/For Demo) --}}
            <div class="flex justify-end mb-4">
                <div class="flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-full border border-slate-200 w-fit ml-auto">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider"><i class="fa-solid fa-eye mr-1"></i> View</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="toggle" id="adminToggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-slate-300 appearance-none cursor-pointer transition-all duration-300 z-10 top-0 left-0 checked:left-5 checked:border-secondary"/>
                        <label for="adminToggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-slate-300 cursor-pointer transition-colors duration-300"></label>
                    </div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider"><i class="fa-solid fa-pen-to-square mr-1"></i> Edit</span>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand text-xs font-bold uppercase tracking-wide mb-4">
                <i class="fa-solid fa-calendar-check text-secondary"></i>
                Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
            </div>
            
            <div class="content-block">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition" title="Edit Judul"><i class="fa-solid fa-pen"></i></button>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                    Informasi Lengkap Pendaftaran Jalur Prestasi & Reguler
                </h1>
            </div>

            <div class="flex items-center justify-center gap-4 text-sm text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span>Panitia PPDB</span>
                </div>
                <span>•</span>
                <span>Diperbarui {{ date('d F Y') }}</span>
                <span>•</span>
                <span><i class="fa-regular fa-clock"></i> 3 mnt baca</span>
            </div>
        </div>
    </header>

    {{-- Main Content Article --}}
    <main class="py-10 bg-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 article-content">

            <!-- Intro Text Block -->
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Edit Teks"><i class="fa-solid fa-pen"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                <p>Selamat datang calon siswa-siswi SMKN 1 Wringin! Kami membuka kesempatan bagi talenta-talenta muda untuk bergabung dan berkembang bersama dalam ekosistem pendidikan vokasi berbasis <strong>Budaya Positif</strong>.</p>
                <p>Penerimaan Peserta Didik Baru (PPDB) tahun ini dilakukan secara terpusat melalui portal online untuk menjamin transparansi dan kemudahan akses bagi seluruh pendaftar dari berbagai daerah.</p>
            </div>

            <!-- Image Block -->
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block my-8">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Ganti Gambar"><i class="fa-regular fa-image"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                <figure class="m-0">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Suasana Ujian" class="w-full h-auto rounded-2xl shadow-lg border border-slate-100 object-cover max-h-[400px]">
                    <figcaption class="text-center text-sm text-slate-500 mt-3 italic">Calon siswa sedang mengikuti simulasi tes minat bakat di Lab Komputer.</figcaption>
                </figure>
            </div>

            <!-- Heading & List Block -->
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Edit Teks"><i class="fa-solid fa-pen"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                <h2>Persyaratan Umum Pendaftaran</h2>
                <p>Sebelum memulai proses pendaftaran, pastikan Anda telah menyiapkan dokumen digital (scan) berikut ini. Ukuran maksimal setiap file adalah 2MB dalam format PDF atau JPG.</p>
                <ul>
                    <li>Scan Kartu Keluarga (KK) asli.</li>
                    <li>Scan Surat Keterangan Lulus (SKL) atau Ijazah SMP/sederajat.</li>
                    <li>Scan Akta Kelahiran.</li>
                    <li>Pas foto terbaru (latar merah) ukuran 3x4.</li>
                    <li>Sertifikat prestasi akademik/non-akademik minimal tingkat Kabupaten/Kota (Khusus Jalur Prestasi).</li>
                </ul>
            </div>

            <!-- File Download Block -->
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block my-10">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Edit File"><i class="fa-solid fa-file-arrow-up"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                
                <!-- Component: File Card -->
                <div class="bg-brand-50 border border-brand-100 rounded-2xl p-5 hover:shadow-md transition-shadow group flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center text-red-500 text-3xl shadow-sm border border-slate-100 flex-shrink-0">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base leading-tight mb-1">Brosur_Resmi_PPDB_SMKN_1_Wringin_{{ date('Y') }}.pdf</h4>
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <span><i class="fa-solid fa-hard-drive mr-1"></i> 2.4 MB</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-download mr-1"></i> 1.2k kali</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="w-full sm:w-auto text-center px-6 py-2.5 bg-brand text-white font-bold rounded-xl hover:bg-brand-700 transition flex items-center justify-center gap-2 flex-shrink-0 shadow-sm group-hover:shadow group-hover:-translate-y-0.5">
                        Unduh File <i class="fa-solid fa-arrow-down"></i>
                    </a>
                </div>
            </div>

            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block my-10">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Edit File"><i class="fa-solid fa-file-arrow-up"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                
                <!-- Component: File Card (DOC) -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 hover:shadow-md transition-shadow group flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center text-blue-600 text-3xl shadow-sm border border-slate-100 flex-shrink-0">
                            <i class="fa-solid fa-file-word"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base leading-tight mb-1">Format_Surat_Pernyataan_Wali.docx</h4>
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <span><i class="fa-solid fa-hard-drive mr-1"></i> 45 KB</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-download mr-1"></i> 850 kali</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="w-full sm:w-auto text-center px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:text-brand transition flex items-center justify-center gap-2 flex-shrink-0 shadow-sm">
                        Unduh File <i class="fa-solid fa-arrow-down"></i>
                    </a>
                </div>
            </div>

            <!-- Link Block -->
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>
            <div class="content-block">
                <div class="admin-controls">
                    <button class="p-2 text-slate-500 hover:text-brand hover:bg-slate-50 transition border-r border-slate-200" title="Edit Tautan"><i class="fa-solid fa-link"></i></button>
                    <button class="p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 transition" title="Hapus Blok"><i class="fa-solid fa-trash"></i></button>
                </div>
                <h2>Akses Pendaftaran Online</h2>
                <p>Silakan klik tautan di bawah ini untuk menuju ke portal pendaftaran sesuai dengan jalur yang Anda pilih:</p>
                
                <div class="flex flex-col gap-4 mt-6">
                    <!-- Component: Styled Link -->
                    <a href="#" class="inline-flex items-center justify-between p-4 rounded-xl bg-white border-2 border-brand/20 hover:border-brand hover:shadow-md transition group text-lg">
                        <span class="font-bold text-brand group-hover:text-brand-700">Formulir Jalur Prestasi (Akademik & Non-Akademik)</span>
                        <div class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center text-brand group-hover:bg-brand group-hover:text-white transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </a>
                    
                    <a href="#" class="inline-flex items-center justify-between p-4 rounded-xl bg-white border-2 border-slate-200 hover:border-secondary hover:shadow-md transition group text-lg">
                        <span class="font-bold text-slate-700 group-hover:text-slate-900">Formulir Jalur Reguler (Tes Tulis)</span>
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-secondary group-hover:text-white transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="add-block-btn" title="Tambah Blok Konten"><div class="add-block-btn-icon"><i class="fa-solid fa-plus"></i></div></div>

        </div>
    </main>

    <!-- Help/Contact Section -->
    <section class="py-16 bg-brand-50 border-t border-brand-100">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-brand mb-4">Butuh Bantuan?</h3>
            <p class="text-slate-600 mb-8">Tim panitia kami siap membantu menjawab pertanyaan Anda terkait proses PPDB pada jam kerja (08:00 - 15:00 WIB).</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-md transition">
                    <i class="fa-brands fa-whatsapp text-xl"></i> Chat WhatsApp
                </a>
                <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-300 hover:border-brand hover:text-brand text-slate-700 font-bold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-envelope"></i> Kirim Email
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const adminToggle = document.getElementById('adminToggle');
        const body = document.body;

        // Handle Toggle Switch
        if (adminToggle) {
            adminToggle.addEventListener('change', function() {
                if(this.checked) {
                    body.classList.add('is-admin');
                    console.log("Admin Mode: Active. Anda dapat mengedit konten.");
                } else {
                    body.classList.remove('is-admin');
                    console.log("Admin Mode: Inactive.");
                }
            });
        }

        // Prevent default link actions for the "Edit" buttons
        const adminButtons = document.querySelectorAll('.admin-controls button');
        adminButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const action = btn.getAttribute('title');
                alert(`Simulasi UI: Fungsi [${action}] ditekan. Di sistem nyata, ini akan membuka modal editor.`);
            });
        });
        
        const addButtons = document.querySelectorAll('.add-block-btn');
        addButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                alert(`Simulasi UI: Fungsi [Tambah Blok Baru] ditekan. Di sistem nyata, ini akan memunculkan menu pilihan (Teks, Gambar, File, Tautan).`);
            });
        });
    });
</script>
@endpush
