<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderPpdbBlockRequest;
use App\Http\Requests\StorePpdbBlockRequest;
use App\Http\Requests\UpdatePpdbBlockRequest;
use App\Http\Requests\UpdatePpdbHeaderRequest;
use App\Jobs\ProcessPhotoZipImport;
use App\Models\HomeFeaturedExtracurricular;
use App\Models\HomePageSetting;
use App\Models\GraduationSetting;
use App\Models\ImportJob;
use App\Models\PageBlock;
use App\Models\PageContent;
use App\Models\PageImage;
use App\Models\Siswa;
use App\Services\HomePageContentService;
use App\Services\PageBuilderContentService;
use App\Services\PageImageUploadService;
use App\Services\PpdbPageBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use ZipArchive;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function login()
    {
        return view('graduation.login');
    }

    /**
     * Proses autentikasi admin.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = strtolower($request->input('username')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember-me'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'username' => trans('auth.failed'),
        ]);
    }

    /**
     * Tampilkan halaman dashboard utama admin.
     */
    public function dashboard()
    {
        // Data dummy untuk status server Green Cloud VPS
        $serverStats = [
            'name' => 'Production-Server-01',
            'status' => 'running', // running, suspended, etc
            'cpu_usage' => 12.5,
            'cpu_cores' => 2,
            'ram_used' => 1024, // MB
            'ram_total' => 4096, // MB
            'ram_percentage' => 25,
            'storage_used' => 12.4,
            'storage_total' => 50,
            'storage_percentage' => 24.8,
            'bandwidth_used' => 450,
            'bandwidth_total' => 2000,
            'bandwidth_percentage' => 22.5,
            'traffic_rx' => '85.05 GB', // Download
            'traffic_tx' => '69.34 GB', // Upload
            'next_billing' => '2026-06-05',
            'days_remaining' => 31,
            'server_ip' => '103.150.190.11',
            'server_ipv6' => '2604:f440:4:5:4::a',
            'hostname' => 'smkn1wringin.sch.id'
        ];

        return view('graduation.admin', compact('serverStats'));
    }

    public function galleryManagement(HomePageContentService $homePageContentService, PageBuilderContentService $pageBuilderContentService)
    {
        // Daftar Ekskul dari view ekstrakurikuler
        $ekskulList = $this->homeEkskulReference();

        $homeContent = Schema::hasTable('home_page_settings')
            ? $homePageContentService->getPayload()
            : [
                'hero_badge_text' => 'Penerimaan Siswa Baru Tahun 2025',
                'is_badge_visible' => true,
                'total_ekskul' => 10,
                'siswa_aktif' => 1200,
                'total_prestasi' => 85,
                'mitra_industri' => '25+',
                'alamat' => 'Jl. Pendidikan No. 45, Wringin, Bondowoso, Jawa Timur',
                'nomor_telepon' => '(0332) 555-0199',
                'email' => 'admin@smkn1wringin.sch.id',
                'persen_melanjutkan_kuliah' => 32,
                'persen_bekerja_berwirausaha' => 68,
                'tahun_mengabdi' => 25,
                'tahun_ppdb' => (int) date('Y'),
                'featured_ekskul' => ['Pramuka', 'E-Sports Club', 'Bola Basket'],
            ];

        $profilContent = $pageBuilderContentService->getPagePayload('profil');
        $profilMeta = $profilContent['meta'] ?? [];

        $ekstrakurikulerOptions = [
            ['slug' => 'pramuka', 'name' => 'Pramuka'],
            ['slug' => 'pmr', 'name' => 'Palang Merah Remaja'],
            ['slug' => 'hadrah', 'name' => 'Seni Hadrah'],
            ['slug' => 'futsal', 'name' => 'Sepak Bola & Futsal'],
            ['slug' => 'basket', 'name' => 'Bola Basket'],
            ['slug' => 'voli', 'name' => 'Bola Voli'],
            ['slug' => 'esports', 'name' => 'E-Sports Club'],
            ['slug' => 'tari-vokal', 'name' => 'Seni Tari & Vokal'],
            ['slug' => 'vm-media', 'name' => 'VM Media'],
            ['slug' => 'sains-club', 'name' => 'Sains Club'],
        ];

        $ekstrakurikulerUrls = [];
        $ekstrakurikulerImagesBySlug = [];

        foreach ($ekstrakurikulerOptions as $ekstrakurikulerOption) {
            $slug = $ekstrakurikulerOption['slug'];
            $name = $ekstrakurikulerOption['name'];

            $ekstrakurikulerUrls[$slug] = route('ekstrakurikuler.detail', ['slug' => $slug]);
            $ekstrakurikulerImagesBySlug[$slug] = [
                ['id' => 20, 'key' => 'hero_image', 'title' => 'Hero '.$name, 'section' => 'Hero', 'ratio' => '1/1', 'ratio_val' => 1],
                ['id' => 21, 'key' => 'gallery_1', 'title' => 'Galeri Utama', 'section' => 'Galeri Kegiatan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                ['id' => 22, 'key' => 'gallery_2', 'title' => 'Galeri 2', 'section' => 'Galeri Kegiatan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                ['id' => 23, 'key' => 'gallery_3', 'title' => 'Galeri 3', 'section' => 'Galeri Kegiatan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                ['id' => 24, 'key' => 'gallery_4', 'title' => 'Galeri 4', 'section' => 'Galeri Kegiatan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                ['id' => 25, 'key' => 'gallery_5', 'title' => 'Galeri 5', 'section' => 'Galeri Kegiatan', 'ratio' => '4/3', 'ratio_val' => 1.333],
            ];
        }

        // Daftar variabel konten untuk frontend editor (tanpa berita)
        $pages = [
            'landing' => [
                'name' => 'Landing Page (Beranda)',
                'icon' => 'home',
                'url' => route('landing'),
                'stats' => true,
                'featured_ekskul' => true,
                'content_fields' => [
                    ['key' => 'hero_badge_text', 'label' => 'Hero Badge Text', 'type' => 'text', 'value' => $homeContent['hero_badge_text'] ?? 'Penerimaan Siswa Baru Tahun 2025'],
                    ['key' => 'is_badge_visible', 'label' => 'Badge Ditampilkan', 'type' => 'boolean', 'value' => (bool) ($homeContent['is_badge_visible'] ?? true)],
                    ['key' => 'total_ekskul', 'label' => 'Total Ekskul', 'type' => 'number', 'value' => (string) ($homeContent['total_ekskul'] ?? 10)],
                    ['key' => 'siswa_aktif', 'label' => 'Siswa Aktif', 'type' => 'number', 'value' => (string) ($homeContent['siswa_aktif'] ?? 1200)],
                    ['key' => 'total_prestasi', 'label' => 'Total Prestasi', 'type' => 'number', 'value' => (string) ($homeContent['total_prestasi'] ?? 85)],
                    ['key' => 'mitra_industri', 'label' => 'Mitra Industri', 'type' => 'text', 'value' => $homeContent['mitra_industri'] ?? '25+'],
                    ['key' => 'persen_melanjutkan_kuliah', 'label' => 'Melanjutkan Kuliah (%)', 'type' => 'number', 'value' => (string) ($homeContent['persen_melanjutkan_kuliah'] ?? 32)],
                    ['key' => 'persen_bekerja_berwirausaha', 'label' => 'Bekerja/Berwirausaha (%)', 'type' => 'number', 'value' => (string) ($homeContent['persen_bekerja_berwirausaha'] ?? 68)],
                    ['key' => 'tahun_mengabdi', 'label' => 'Tahun Mengabdi', 'type' => 'number', 'value' => (string) ($homeContent['tahun_mengabdi'] ?? 25)],
                    ['key' => 'tahun_ppdb', 'label' => 'Tahun PPDB Pertama', 'type' => 'number', 'value' => (string) ($homeContent['tahun_ppdb'] ?? date('Y'))],
                ],
                'images' => [
                    ['id' => 1, 'key' => 'hero_main', 'title' => 'Hero Utama', 'section' => 'Hero', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 2, 'key' => 'sambutan_kepala_sekolah', 'title' => 'Foto Kepala Sekolah', 'section' => 'Sambutan', 'ratio' => '4/5', 'ratio_val' => 0.8],
                    ['id' => 3, 'key' => 'profil_guru', 'title' => 'Profil Guru', 'section' => 'Profil', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 4, 'key' => 'profil_praktek', 'title' => 'Profil Praktik', 'section' => 'Profil', 'ratio' => '4/3', 'ratio_val' => 1.333],
                ],
            ],
            'profil' => [
                'name' => 'Profil Sekolah',
                'icon' => 'bookmark',
                'url' => route('profil'),
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_badge_text', 'label' => 'Hero Badge', 'type' => 'text', 'value' => $profilMeta['hero_badge_text'] ?? '22 Tahun Mengabdi'],
                    ['key' => 'hero_title', 'label' => 'Hero Judul', 'type' => 'text', 'value' => $profilMeta['hero_title'] ?? 'Mengenal Lebih Dekat SMKN 1 Wringin'],
                    ['key' => 'hero_description', 'label' => 'Hero Deskripsi', 'type' => 'textarea', 'value' => $profilMeta['hero_description'] ?? 'Menjadi SMK Pusat Keunggulan yang mencetak generasi Creativepreneur berkarakter, siap bersaing di dunia industri dan usaha.'],
                    ['key' => 'sejarah_title', 'label' => 'Judul Sejarah', 'type' => 'text', 'value' => $profilMeta['sejarah_title'] ?? 'Sejarah Berdirinya SmakinOne'],
                    ['key' => 'sejarah_body', 'label' => 'Isi Sejarah', 'type' => 'textarea', 'value' => $profilMeta['sejarah_body'] ?? ''],
                    ['key' => 'keunggulan_intro', 'label' => 'Intro Keunggulan', 'type' => 'textarea', 'value' => $profilMeta['keunggulan_intro'] ?? 'Lingkungan belajar yang holistik untuk mencetak talenta-talenta siap kerja dan siap berkarya.'],
                    ['key' => 'keunggulan_items', 'label' => 'Poin Keunggulan', 'type' => 'textarea', 'value' => $profilMeta['keunggulan_items'] ?? ''],
                    ['key' => 'visi_title', 'label' => 'Judul Visi', 'type' => 'text', 'value' => $profilMeta['visi_title'] ?? 'Terwujudnya Lulusan SMAKIN KEREN'],
                    ['key' => 'visi_body', 'label' => 'Isi Visi', 'type' => 'textarea', 'value' => $profilMeta['visi_body'] ?? 'Lulusan SMKN 1 Wringin sebagai Creativepreneur Berkarakter'],
                    ['key' => 'misi_items', 'label' => 'Daftar Misi', 'type' => 'textarea', 'value' => $profilMeta['misi_items'] ?? ''],
                    ['key' => 'motto_text', 'label' => 'Motto', 'type' => 'text', 'value' => $profilMeta['motto_text'] ?? 'Creativepreneurs Start Here'],
                    ['key' => 'cta_title', 'label' => 'Judul CTA', 'type' => 'text', 'value' => $profilMeta['cta_title'] ?? 'Bergabunglah Bersama Keluarga Besar Kami'],
                    ['key' => 'cta_description', 'label' => 'Deskripsi CTA', 'type' => 'textarea', 'value' => $profilMeta['cta_description'] ?? 'Jadilah bagian dari generasi penerus yang inovatif, berkarakter, dan siap menghadapi tantangan masa depan bersama SMKN 1 Wringin.'],
                ],
                'images' => [],
            ],
            'jurusan_detail' => [
                'name' => 'Detail Jurusan',
                'icon' => 'layers',
                'url' => route('jurusan.detail', ['slug' => 'tav']),
                'jurusan_urls' => [
                    'tav' => route('jurusan.detail', ['slug' => 'tav']),
                    'dkv' => route('jurusan.detail', ['slug' => 'dkv']),
                    'tkj' => route('jurusan.detail', ['slug' => 'tkj']),
                    'tkro' => route('jurusan.detail', ['slug' => 'tkro']),
                ],
                'jurusan_options' => [
                    ['slug' => 'tav', 'name' => 'Teknik Audio Video (TAV)'],
                    ['slug' => 'dkv', 'name' => 'Desain Komunikasi Visual (DKV)'],
                    ['slug' => 'tkj', 'name' => 'Teknik Komputer Jaringan (TKJ)'],
                    ['slug' => 'tkro', 'name' => 'Teknik Kendaraan Ringan Otomotif (TKRO)'],
                ],
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_description', 'label' => 'Hero Deskripsi', 'type' => 'textarea', 'value' => 'Membekali siswa dengan kompetensi instalasi, perawatan, dan perbaikan perangkat audio video serta sistem elektronika modern.'],
                ],
                'images_by_slug' => [
                    'tav' => [
                        ['id' => 8, 'key' => 'hero_image', 'title' => 'Foto Jurusan', 'section' => 'Mengenal Jurusan', 'ratio' => '16/9', 'ratio_val' => 1.777],
                        ['id' => 9, 'key' => 'gallery_1', 'title' => 'Galeri Utama', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 10, 'key' => 'gallery_2', 'title' => 'Galeri 2', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 11, 'key' => 'gallery_3', 'title' => 'Galeri 3', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 12, 'key' => 'gallery_4', 'title' => 'Galeri 4', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 13, 'key' => 'gallery_5', 'title' => 'Galeri 5', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ],
                    'dkv' => [
                        ['id' => 8, 'key' => 'hero_image', 'title' => 'Foto Jurusan', 'section' => 'Mengenal Jurusan', 'ratio' => '16/9', 'ratio_val' => 1.777],
                        ['id' => 9, 'key' => 'gallery_1', 'title' => 'Galeri Utama', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 10, 'key' => 'gallery_2', 'title' => 'Galeri 2', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 11, 'key' => 'gallery_3', 'title' => 'Galeri 3', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 12, 'key' => 'gallery_4', 'title' => 'Galeri 4', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 13, 'key' => 'gallery_5', 'title' => 'Galeri 5', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ],
                    'tkj' => [
                        ['id' => 8, 'key' => 'hero_image', 'title' => 'Foto Jurusan', 'section' => 'Mengenal Jurusan', 'ratio' => '16/9', 'ratio_val' => 1.777],
                        ['id' => 9, 'key' => 'gallery_1', 'title' => 'Galeri Utama', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 10, 'key' => 'gallery_2', 'title' => 'Galeri 2', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 11, 'key' => 'gallery_3', 'title' => 'Galeri 3', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 12, 'key' => 'gallery_4', 'title' => 'Galeri 4', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 13, 'key' => 'gallery_5', 'title' => 'Galeri 5', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ],
                    'tkro' => [
                        ['id' => 8, 'key' => 'hero_image', 'title' => 'Foto Jurusan', 'section' => 'Mengenal Jurusan', 'ratio' => '16/9', 'ratio_val' => 1.777],
                        ['id' => 9, 'key' => 'gallery_1', 'title' => 'Galeri Utama', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 10, 'key' => 'gallery_2', 'title' => 'Galeri 2', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 11, 'key' => 'gallery_3', 'title' => 'Galeri 3', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 12, 'key' => 'gallery_4', 'title' => 'Galeri 4', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                        ['id' => 13, 'key' => 'gallery_5', 'title' => 'Galeri 5', 'section' => 'Galeri Jurusan', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ],
                ],
            ],
            'budaya_positif' => [
                'name' => 'Budaya Positif',
                'icon' => 'shield',
                'url' => route('budaya.positif'),
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_title', 'label' => 'Hero Judul', 'type' => 'text', 'value' => 'Lebih dari Sekadar Aturan, Ini Cara Kami Berkarya'],
                    ['key' => 'hero_description', 'label' => 'Hero Deskripsi', 'type' => 'textarea', 'value' => 'Membentuk karakter profesional muda melalui ekosistem belajar yang suportif, disiplin, dan berintegritas untuk menghadapi tuntutan dunia industri yang nyata.'],
                ],
                'images' => [
                    ['id' => 14, 'key' => 'hero_background', 'title' => 'Hero Background', 'section' => 'Hero', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 15, 'key' => 'core_value_disiplin', 'title' => 'Core Value - Disiplin', 'section' => 'Nilai Inti', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 16, 'key' => 'core_value_integritas', 'title' => 'Core Value - Integritas', 'section' => 'Nilai Inti', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 17, 'key' => 'core_value_kolaborasi', 'title' => 'Core Value - Kolaborasi', 'section' => 'Nilai Inti', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 18, 'key' => 'core_value_hormat', 'title' => 'Core Value - Hormat & Empati', 'section' => 'Nilai Inti', 'ratio' => '4/3', 'ratio_val' => 1.333],
                    ['id' => 19, 'key' => 'implementasi_briefing', 'title' => 'Implementasi - Briefing', 'section' => 'Implementasi', 'ratio' => '16/9', 'ratio_val' => 1.777],
                ],
            ],
            'ekstrakurikuler_detail' => [
                'name' => 'Ekstrakurikuler',
                'icon' => 'activity',
                'url' => route('ekstrakurikuler.detail', ['slug' => 'pramuka']),
                'ekstrakurikuler_urls' => $ekstrakurikulerUrls,
                'ekstrakurikuler_options' => $ekstrakurikulerOptions,
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [],
                'images_by_slug' => $ekstrakurikulerImagesBySlug,
            ],
            'sarana_prasarana' => [
                'name' => 'Sarana Prasarana',
                'icon' => 'grid',
                'url' => route('sarana.prasarana'),
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_title', 'label' => 'Hero Judul', 'type' => 'text', 'value' => 'Praktek Nyata. Bukan Sekadar Teori.'],
                ],
                'images' => [
                    ['id' => 31, 'key' => 'hero_background', 'title' => 'Hero Background', 'section' => 'Hero', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 32, 'key' => 'facility_coding_lab', 'title' => 'Fasilitas - Coding Lab', 'section' => 'Grid Fasilitas', 'ratio' => '3/4', 'ratio_val' => 0.75],
                    ['id' => 33, 'key' => 'facility_auto_workshop', 'title' => 'Fasilitas - Bengkel Auto Pro', 'section' => 'Grid Fasilitas', 'ratio' => '3/4', 'ratio_val' => 0.75],
                    ['id' => 34, 'key' => 'facility_creative_studio', 'title' => 'Fasilitas - Creative Studio', 'section' => 'Grid Fasilitas', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 35, 'key' => 'facility_teaching_factory', 'title' => 'Fasilitas - Teaching Factory', 'section' => 'Grid Fasilitas', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 36, 'key' => 'facility_smart_classroom', 'title' => 'Fasilitas - Smart Classroom', 'section' => 'Grid Fasilitas', 'ratio' => '1/1', 'ratio_val' => 1],
                    ['id' => 37, 'key' => 'facility_digi_library', 'title' => 'Fasilitas - Digi Library', 'section' => 'Grid Fasilitas', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 38, 'key' => 'facility_food_court', 'title' => 'Fasilitas - Food Court', 'section' => 'Grid Fasilitas', 'ratio' => '1/1', 'ratio_val' => 1],
                    ['id' => 39, 'key' => 'facility_sport_arena', 'title' => 'Fasilitas - Indoor Sport Arena', 'section' => 'Grid Fasilitas', 'ratio' => '21/9', 'ratio_val' => 2.333],
                ],
            ],
            'bursa_kerja_khusus' => [
                'name' => 'Bursa Kerja Khusus',
                'icon' => 'briefcase',
                'url' => route('bursa.kerja.khusus'),
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_title', 'label' => 'Hero Judul', 'type' => 'text', 'value' => 'Siap Kerja Setelah Lulus. Karir Impian Dimulai di Sini.'],
                ],
                'images' => [
                    ['id' => 40, 'key' => 'hero_background', 'title' => 'Hero Background', 'section' => 'Hero', 'ratio' => '16/9', 'ratio_val' => 1.777],
                    ['id' => 41, 'key' => 'testimoni_budi', 'title' => 'Foto Testimoni - Budi Santoso', 'section' => 'Testimoni', 'ratio' => '1/1', 'ratio_val' => 1],
                    ['id' => 42, 'key' => 'testimoni_siti', 'title' => 'Foto Testimoni - Siti Aminah', 'section' => 'Testimoni', 'ratio' => '1/1', 'ratio_val' => 1],
                    ['id' => 43, 'key' => 'testimoni_andi', 'title' => 'Foto Testimoni - Andi Wijaya', 'section' => 'Testimoni', 'ratio' => '1/1', 'ratio_val' => 1],
                ],
            ],
            'pembelajaran' => [
                'name' => 'Pembelajaran',
                'icon' => 'book-open',
                'url' => route('pembelajaran'),
                'stats' => false,
                'featured_ekskul' => false,
                'content_fields' => [
                    ['key' => 'hero_title', 'label' => 'Hero Judul', 'type' => 'text', 'value' => 'Membentuk Lulusan Kompeten & Siap Kerja'],
                    ['key' => 'hero_description', 'label' => 'Hero Deskripsi', 'type' => 'textarea', 'value' => 'Kami menerapkan sistem pembelajaran berbasis proyek nyata dan praktik langsung yang disesuaikan dengan standar industri saat ini.'],
                ],
                'images' => [],
            ],
        ];

        $existingImages = [];

        if (Schema::hasTable('page_images')) {
            $existingImages = PageImage::query()
                ->whereIn('page_key', array_keys($pages))
                ->whereNotNull('jpeg_path')
                ->get()
                ->mapWithKeys(function (PageImage $image) {
                    $disk = $image->disk ?: 'public';
                    $version = max(1, (int) $image->cache_version);
                    $jpegPath = (string) $image->jpeg_path;
                    $webpPath = (string) ($image->webp_path ?? '');

                    $key = $image->page_key.'.'.$image->slot_key;

                    if ($image->page_key === 'jurusan_detail' && preg_match('/^(tav|dkv|tkj|tkro)_(hero_image|gallery_[1-5])$/', $image->slot_key, $matches)) {
                        $key = 'jurusan_detail.'.$matches[1].'.'.$matches[2];
                    }

                    if ($image->page_key === 'ekstrakurikuler_detail' && preg_match('/^(pramuka|pmr|hadrah|futsal|basket|voli|esports|tari-vokal|vm-media|sains-club)_(hero_image|gallery_[1-5])$/', $image->slot_key, $matches)) {
                        $key = 'ekstrakurikuler_detail.'.$matches[1].'.'.$matches[2];
                    }

                    $jpegUrl = str_starts_with($jpegPath, 'http://') || str_starts_with($jpegPath, 'https://')
                        ? $jpegPath
                        : (str_starts_with($jpegPath, 'images/') ? asset($jpegPath) : Storage::disk($disk)->url($jpegPath));

                    $webpUrl = null;

                    if ($webpPath !== '') {
                        $webpUrl = str_starts_with($webpPath, 'http://') || str_starts_with($webpPath, 'https://')
                            ? $webpPath
                            : (str_starts_with($webpPath, 'images/') ? asset($webpPath) : Storage::disk($disk)->url($webpPath));
                    }

                    return [
                        $key => [
                            'jpeg_url' => $jpegUrl.'?v='.$version,
                            'webp_url' => $webpUrl ? $webpUrl.'?v='.$version : null,
                            'alt_text' => $image->alt_text,
                        ],
                    ];
                })
                ->all();
        }

        return view('graduation.gallery_management', compact('pages', 'ekskulList', 'existingImages', 'homeContent'));
    }

    public function ppdbBuilder(PageBuilderContentService $pageBuilderContentService)
    {
        if (! $pageBuilderContentService->tablesReady()) {
            return view('graduation.ppdb_builder', [
                'title' => 'Informasi Lengkap Pendaftaran Jalur Prestasi & Reguler',
                'badgeText' => 'Informasi Resmi PPDB',
                'blocks' => [],
                'builderReady' => false,
            ]);
        }

        $payload = $pageBuilderContentService->getPagePayload('ppdb');
        $blocks = collect($payload['blocks'] ?? [])
            ->filter(fn (array $block) => ! is_null($block['id'] ?? null))
            ->values()
            ->all();

        return view('graduation.ppdb_builder', [
            'title' => $payload['title'],
            'badgeText' => $payload['badge_text'] ?? 'Informasi Resmi PPDB',
            'blocks' => $blocks,
            'builderReady' => true,
        ]);
    }

    public function updatePpdbHeader(UpdatePpdbHeaderRequest $request, PpdbPageBuilderService $ppdbPageBuilderService)
    {
        $ppdbPageBuilderService->updateHeader($request->validated(), Auth::id());

        return back()->with('success', 'Judul PPDB berhasil diperbarui.');
    }

    public function storePpdbBlock(StorePpdbBlockRequest $request, PpdbPageBuilderService $ppdbPageBuilderService)
    {
        $validated = $request->validated();

        $ppdbPageBuilderService->createBlock(
            $validated['block_type'],
            $validated,
            $request->file('asset_file'),
            Auth::id(),
        );

        return back()->with('success', 'Blok PPDB berhasil ditambahkan.');
    }

    public function updatePpdbBlock(UpdatePpdbBlockRequest $request, PageBlock $block, PpdbPageBuilderService $ppdbPageBuilderService)
    {
        $this->ensurePpdbBlock($block);

        $ppdbPageBuilderService->updateBlock(
            $block,
            $request->validated(),
            $request->file('asset_file'),
            Auth::id(),
        );

        return back()->with('success', 'Blok PPDB berhasil diperbarui.');
    }

    public function destroyPpdbBlock(PageBlock $block, PpdbPageBuilderService $ppdbPageBuilderService)
    {
        $this->ensurePpdbBlock($block);
        $ppdbPageBuilderService->deleteBlock($block, Auth::id());

        return back()->with('success', 'Blok PPDB berhasil dihapus.');
    }

    public function reorderPpdbBlocks(ReorderPpdbBlockRequest $request, PpdbPageBuilderService $ppdbPageBuilderService)
    {
        $ppdbPageBuilderService->reorderBlocks($request->validated()['block_ids'], Auth::id());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Urutan blok PPDB berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Urutan blok PPDB berhasil diperbarui.');
    }

    public function uploadGalleryImage(Request $request, PageImageUploadService $uploadService)
    {
        if (! Schema::hasTable('page_images')) {
            return response()->json([
                'success' => false,
                'message' => 'Tabel page_images belum tersedia. Jalankan migrasi terlebih dahulu.',
            ], 503);
        }

        $validated = $request->validate([
            'page_key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9_]+$/'],
            'slot_key' => ['required', 'string', 'max:150', 'regex:/^[a-z0-9_-]+$/'],
            'jurusan_slug' => ['nullable', 'string', Rule::in(['tav', 'dkv', 'tkj', 'tkro'])],
            'ekstrakurikuler_slug' => ['nullable', 'string', Rule::in(['pramuka', 'pmr', 'hadrah', 'futsal', 'basket', 'voli', 'esports', 'tari-vokal', 'vm-media', 'sains-club'])],
            'title' => ['required', 'string', 'max:191'],
            'section' => ['nullable', 'string', 'max:150'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'image_data' => ['required', 'string'],
        ]);

        $resolvedSlotKey = $validated['slot_key'];

        if ($validated['page_key'] === 'jurusan_detail') {
            $jurusanSlug = $validated['jurusan_slug'] ?? null;

            if (! $jurusanSlug) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jurusan wajib dipilih untuk mengubah gambar detail jurusan.',
                ], 422);
            }

            $resolvedSlotKey = $jurusanSlug.'_'.$validated['slot_key'];
        }

        if ($validated['page_key'] === 'ekstrakurikuler_detail') {
            $ekstrakurikulerSlug = $validated['ekstrakurikuler_slug'] ?? null;

            if (! $ekstrakurikulerSlug) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ekstrakurikuler wajib dipilih untuk mengubah gambar detail ekstrakurikuler.',
                ], 422);
            }

            $resolvedSlotKey = $ekstrakurikulerSlug.'_'.$validated['slot_key'];
        }

        try {
            $result = $uploadService->uploadFromDataUrl([
                'page_key' => $validated['page_key'],
                'slot_key' => $resolvedSlotKey,
                'title' => $validated['title'],
                'section' => $validated['section'] ?? null,
                'alt_text' => $validated['alt_text'] ?? null,
                'image_data' => $validated['image_data'],
                'disk' => 'public',
                'updated_by' => Auth::id(),
            ]);

            /** @var PageImage $pageImage */
            $pageImage = $result['page_image'];
            $pageVersion = $result['page_version'];

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diperbarui.',
                'data' => [
                    'id' => $pageImage->id,
                    'page_key' => $pageImage->page_key,
                    'slot_key' => $pageImage->slot_key,
                    'jpeg_url' => $result['jpeg_url'].'?v='.$pageVersion,
                    'webp_url' => $result['webp_url'].'?v='.$pageVersion,
                    'page_version' => $pageVersion,
                    'slot_cache_version' => $pageImage->cache_version,
                    'last_generated_at' => optional($pageImage->last_generated_at)->toDateTimeString(),
                ],
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses gambar.',
            ], 500);
        }
    }

    public function updateHomePageSettings(Request $request, HomePageContentService $homePageContentService)
    {
        if (! Schema::hasTable('home_page_settings') || ! Schema::hasTable('home_featured_extracurriculars')) {
            return response()->json([
                'success' => false,
                'message' => 'Tabel pengaturan beranda belum tersedia. Jalankan migrasi terlebih dahulu.',
            ], 503);
        }

        $allowedEkskul = $this->homeEkskulReference();

        $validated = $request->validate([
            'hero_badge_text' => ['nullable', 'string', 'max:191'],
            'is_badge_visible' => ['required', 'boolean'],
            'total_ekskul' => ['required', 'integer', 'min:0'],
            'siswa_aktif' => ['required', 'integer', 'min:0'],
            'total_prestasi' => ['required', 'integer', 'min:0'],
            'mitra_industri' => ['required', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'nomor_telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:120'],
            'persen_melanjutkan_kuliah' => ['required', 'integer', 'min:0', 'max:100'],
            'persen_bekerja_berwirausaha' => ['required', 'integer', 'min:0', 'max:100'],
            'tahun_mengabdi' => ['required', 'integer', 'min:0', 'max:120'],
            'tahun_ppdb' => ['required', 'integer', 'min:2000', 'max:2100'],
            'featured_ekskul' => ['required', 'array', 'size:3'],
            'featured_ekskul.*' => ['required', 'string', Rule::in($allowedEkskul)],
        ]);

        $setting = DB::transaction(function () use ($validated) {
            $setting = HomePageSetting::query()->updateOrCreate(
                ['id' => 1],
                [
                    'hero_badge_text' => trim((string) ($validated['hero_badge_text'] ?? '')),
                    'is_badge_visible' => (bool) $validated['is_badge_visible'],
                    'total_ekskul' => (int) $validated['total_ekskul'],
                    'siswa_aktif' => (int) $validated['siswa_aktif'],
                    'total_prestasi' => (int) $validated['total_prestasi'],
                    'mitra_industri' => trim((string) $validated['mitra_industri']),
                    'alamat' => trim((string) ($validated['alamat'] ?? '')),
                    'nomor_telepon' => trim((string) ($validated['nomor_telepon'] ?? '')),
                    'email' => trim((string) ($validated['email'] ?? '')),
                    'persen_melanjutkan_kuliah' => (int) $validated['persen_melanjutkan_kuliah'],
                    'persen_bekerja_berwirausaha' => (int) $validated['persen_bekerja_berwirausaha'],
                    'tahun_mengabdi' => (int) $validated['tahun_mengabdi'],
                    'tahun_ppdb' => (int) $validated['tahun_ppdb'],
                    'updated_by' => Auth::id(),
                ]
            );

            HomeFeaturedExtracurricular::query()
                ->where('home_page_setting_id', $setting->id)
                ->delete();

            foreach (array_values($validated['featured_ekskul']) as $index => $name) {
                HomeFeaturedExtracurricular::query()->create([
                    'home_page_setting_id' => $setting->id,
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }

            return $setting;
        });

        $newVersion = $homePageContentService->bumpVersion($setting);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan beranda berhasil diperbarui.',
            'data' => [
                'cache_version' => $newVersion,
            ],
        ]);
    }

    public function updatePageContent(Request $request, PageBuilderContentService $pageBuilderContentService)
    {
        if (! Schema::hasTable('page_contents')) {
            return response()->json([
                'success' => false,
                'message' => 'Tabel konten halaman belum tersedia. Jalankan migrasi terlebih dahulu.',
            ], 503);
        }

        $validated = $request->validate([
            'page_key' => ['required', 'string', Rule::in(['profil'])],
            'title' => ['required', 'string', 'max:191'],
            'fields' => ['required', 'array'],
            'fields.hero_badge_text' => ['nullable', 'string', 'max:100'],
            'fields.hero_title' => ['required', 'string', 'max:191'],
            'fields.hero_description' => ['nullable', 'string', 'max:1000'],
            'fields.sejarah_title' => ['required', 'string', 'max:191'],
            'fields.sejarah_body' => ['nullable', 'string', 'max:5000'],
            'fields.keunggulan_intro' => ['nullable', 'string', 'max:1000'],
            'fields.keunggulan_items' => ['nullable', 'string', 'max:3000'],
            'fields.visi_title' => ['required', 'string', 'max:191'],
            'fields.visi_body' => ['nullable', 'string', 'max:1000'],
            'fields.misi_items' => ['nullable', 'string', 'max:3000'],
            'fields.motto_text' => ['required', 'string', 'max:191'],
            'fields.cta_title' => ['required', 'string', 'max:191'],
            'fields.cta_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $pageContent = DB::transaction(function () use ($validated) {
            return PageContent::query()->updateOrCreate(
                ['page_key' => $validated['page_key']],
                [
                    'title' => trim((string) $validated['title']),
                    'meta' => collect($validated['fields'])
                        ->map(fn ($value) => trim((string) ($value ?? '')))
                        ->all(),
                    'is_initialized' => true,
                    'updated_by' => Auth::id(),
                ]
            );
        });

        $newVersion = $pageBuilderContentService->bumpVersion($pageContent);

        return response()->json([
            'success' => true,
            'message' => 'Konten halaman profil berhasil diperbarui.',
            'data' => [
                'cache_version' => $newVersion,
            ],
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function homeEkskulReference(): array
    {
        return [
            'Pramuka',
            'Palang Merah Remaja',
            'Seni Hadrah',
            'Sepak Bola & Futsal',
            'Bola Basket',
            'Bola Voli',
            'E-Sports Club',
            'Seni Tari & Vokal',
            'VM Media',
            'Sains Club',
        ];
    }

    /**
     * Tampilkan halaman manajemen data kelulusan.
     */
    public function graduationData()
    {
        $siswas = Siswa::latest()->paginate(15);
        
        $queryTanpaFoto = Siswa::where(function($q) {
            $q->whereNull('pas_foto')->orWhere('pas_foto', '');
        });

        $stats = [
            'total' => Siswa::count(),
            'lulus' => Siswa::whereRaw("UPPER(TRIM(status_kelulusan)) = ?", ['LULUS'])->count(),
            'tidak_lulus' => Siswa::whereRaw("UPPER(TRIM(status_kelulusan)) = ?", ['TIDAK LULUS'])->count(),
            'tanpa_foto' => $queryTanpaFoto->count(),
        ];

        $siswas_tanpa_foto = $queryTanpaFoto->select('nama', 'nisn', 'kelas')->get();

        $latestPhotoImportJob = ImportJob::where('type', 'photo_zip')->latest()->first();

        $graduationSetting = GraduationSetting::latest()->first();
        if (!$graduationSetting) {
            $graduationSetting = new GraduationSetting([
                'angkatan' => '2026',
                'lulusan' => '2026',
                'tanggal_pengumuman' => '2026-05-06',
                'jam_pengumuman' => '10:00',
            ]);
        }

        return view('graduation.data_kelulusan', compact('siswas', 'stats', 'siswas_tanpa_foto', 'graduationSetting', 'latestPhotoImportJob'));
    }

    public function updateGraduationSetting(Request $request)
    {
        $validated = $request->validate([
            'angkatan' => ['required', 'string', 'max:255'],
            'lulusan' => ['required', 'string', 'max:255'],
            'tanggal_pengumuman' => ['required', 'date'],
            'jam_pengumuman' => ['required', 'date_format:H:i'],
        ]);

        GraduationSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'angkatan' => trim($validated['angkatan']),
                'lulusan' => trim($validated['lulusan']),
                'tanggal_pengumuman' => $validated['tanggal_pengumuman'],
                'jam_pengumuman' => $validated['jam_pengumuman'],
            ]
        );

        return back()->with('success', 'Pengaturan pengumuman kelulusan berhasil diperbarui.');
    }

    public function apiShowSiswa($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $siswa->setAttribute('pas_foto_url', $siswa->photoUrl());

        return response()->json([
            'success' => true,
            'message' => 'Detail siswa berhasil diambil.',
            'data' => $siswa,
        ]);
    }

    public function apiUpdateSiswa(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $payload = $request->all();
        $statusRaw = preg_replace('/\s+/', ' ', trim((string) ($payload['status_kelulusan'] ?? '')));
        if ($statusRaw === '') {
            $payload['status_kelulusan'] = null;
        } elseif (strtoupper($statusRaw) === 'LULUS') {
            $payload['status_kelulusan'] = 'Lulus';
        } elseif (strtoupper($statusRaw) === 'TIDAK LULUS') {
            $payload['status_kelulusan'] = 'Tidak Lulus';
        }

        if (($payload['tanggal_lahir'] ?? null) === '') {
            $payload['tanggal_lahir'] = null;
        }

        $validator = Validator::make($payload, [
            'username' => ['required', 'string', 'max:255', Rule::unique('siswas', 'username')->ignore($siswa->id)],
            'nama' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:50', Rule::unique('siswas', 'nisn')->ignore($siswa->id)],
            'kelas' => ['nullable', 'string', 'max:255'],
            'can_submit_news' => ['nullable', 'boolean'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'status_kelulusan' => ['nullable', 'in:Lulus,Tidak Lulus'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $siswa->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui.',
            'data' => $siswa->fresh(),
        ]);
    }

    public function apiDeleteSiswa($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus.',
        ]);
    }

    /**
     * Proses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * Proses import data siswa dari Excel/CSV.
     */
    public function importExcel(Request $request)
    {
        // Tingkatkan batas waktu eksekusi untuk menangani proses hashing/convert yang banyak
        set_time_limit(300);

        $request->validate([
            'file' => 'required|max:10240', // Mimes checked manually below to be safer
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        if ($extension === 'csv') {
            return $this->importFromCsv($file);
        } else {
            return $this->importFromExcel($file);
        }
    }

    /**
     * Helper untuk import dari CSV secara native.
     */
    private function importFromCsv($file)
    {
        if (($handle = fopen($file->path(), "r")) !== FALSE) {
            // Skip header
            $header = fgetcsv($handle, 1000, ",");
            
            $count = 0;
            $passwordCache = [];

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($data) < 4 || empty($data[3])) continue;
                
                $rawPassword = $data[1] ?? 'password123';
                if (!isset($passwordCache[$rawPassword])) {
                    $passwordCache[$rawPassword] = \Illuminate\Support\Facades\Hash::make($rawPassword);
                }
                $hashedPassword = $passwordCache[$rawPassword];

                Siswa::updateOrCreate(
                    ['nisn' => $data[3]],
                    [
                        'username' => $data[0],
                        'password' => $hashedPassword,
                        'nama' => $data[2],
                        'kelas' => $data[4] ?? '',
                        'tempat_lahir' => $data[5] ?? '',
                        'tanggal_lahir' => (isset($data[6]) && !empty($data[6])) ? date('Y-m-d', strtotime($data[6])) : null,
                        'status_kelulusan' => $data[7] ?? '',
                    ]
                );
                $count++;
            }
            fclose($handle);
            return back()->with('success', $count . ' data siswa berhasil diimport dari CSV.');
        }
        return back()->withErrors(['file' => 'Gagal membaca file CSV.']);
    }

    /**
     * Helper untuk import dari Excel menggunakan PhpSpreadsheet.
     */
    private function importFromExcel($file)
    {
        try {
            if (!class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
                throw new \Exception('Library PhpSpreadsheet belum terinstall.');
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->path());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Hapus header
            array_shift($rows);
            
            $count = 0;
            $passwordCache = []; // Cache hash untuk mempercepat proses

            foreach ($rows as $data) {
                // Bersihkan data dari spasi atau null
                $nisn = trim($data[3] ?? '');
                if (empty($nisn)) continue;
                
                $rawPassword = $data[1] ?? 'password123';
                
                // Gunakan cache hash jika password sama
                if (!isset($passwordCache[$rawPassword])) {
                    $passwordCache[$rawPassword] = \Illuminate\Support\Facades\Hash::make($rawPassword);
                }
                $hashedPassword = $passwordCache[$rawPassword];

                Siswa::updateOrCreate(
                    ['nisn' => $nisn],
                    [
                        'username' => $data[0] ?? 'siswa',
                        'password' => $hashedPassword,
                        'nama' => $data[2] ?? 'Tanpa Nama',
                        'kelas' => $data[4] ?? '',
                        'tempat_lahir' => $data[5] ?? '',
                        'tanggal_lahir' => (isset($data[6]) && !empty($data[6])) ? date('Y-m-d', strtotime($data[6])) : null,
                        'status_kelulusan' => $data[7] ?? '',
                    ]
                );
                $count++;
            }
            
            return back()->with('success', $count . ' data siswa berhasil diimport dari Excel.');
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => 'Gagal memproses file Excel. ' . $e->getMessage()]);
        }
    }

    /**
     * Proses import foto siswa dari ZIP.
     */
    public function importZip(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:zip', 'max:51200'],
        ]);

        $zipFile = $request->file('file');

        $zip = new ZipArchive();
        if ($zip->open($zipFile->path()) !== true) {
            return back()->withErrors(['file' => 'Gagal membuka file ZIP. Pastikan file tidak rusak.']);
        }

        $zip->close();

        $uuid = (string) Str::uuid();
        $zipPath = $zipFile->storeAs('imports/photo-zips', $uuid . '.zip', 'local');

        $importJob = ImportJob::create([
            'uuid' => $uuid,
            'admin_user_id' => Auth::id(),
            'type' => 'photo_zip',
            'original_filename' => $zipFile->getClientOriginalName(),
            'zip_path' => $zipPath,
            'status' => 'queued',
        ]);

        ProcessPhotoZipImport::dispatch($importJob->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Import foto sedang diproses di background.',
                'data' => [
                    'uuid' => $importJob->uuid,
                    'status' => $importJob->status,
                    'original_filename' => $importJob->original_filename,
                    'status_url' => route('admin.import-jobs.status', $importJob->uuid),
                ],
            ]);
        }

        return back()
            ->with('success', 'Import foto sedang diproses di background. Anda dapat meninggalkan halaman ini tanpa menghentikan proses.')
            ->with('import_job_uuid', $importJob->uuid);
    }

    public function importJobStatus(string $uuid)
    {
        $importJob = ImportJob::where('uuid', $uuid)->first();

        if (!$importJob) {
            return response()->json([
                'success' => false,
                'message' => 'Job import tidak ditemukan.',
            ], 404);
        }

        $progress = $importJob->total_files > 0
            ? round(($importJob->processed_files / $importJob->total_files) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'uuid' => $importJob->uuid,
                'status' => $importJob->status,
                'original_filename' => $importJob->original_filename,
                'total_files' => $importJob->total_files,
                'processed_files' => $importJob->processed_files,
                'success_count' => $importJob->success_count,
                'failed_count' => $importJob->failed_count,
                'progress' => $progress,
                'error_summary' => $importJob->error_summary ?? [],
                'started_at' => $importJob->started_at?->toDateTimeString(),
                'finished_at' => $importJob->finished_at?->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Download template CSV untuk import siswa.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_siswa.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Username', 'Password', 'Nama', 'NISN', 'Kelas', 'Tempat_Lahir', 'Tanggal_Lahir (YYYY-MM-DD)', 'Status_Kelulusan']);
            fputcsv($file, ['siswa1', 'password123', 'Ahmad Budi', '0012345678', 'XII RPL 1', 'Bondowoso', '2008-01-01', 'Lulus']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function ensurePpdbBlock(PageBlock $block): void
    {
        if ($block->page_key !== 'ppdb') {
            abort(404);
        }
    }
}
