<?php

namespace App\Http\Controllers;

use App\Services\HomePageContentService;
use App\Services\NewsContentService;
use App\Services\PageBuilderContentService;
use App\Services\PageImageContentService;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LandingController extends Controller
{
    private const DEFAULT_JPEG_PATH = 'images/alternative/default_picture.jpeg';
    private const DEFAULT_WEBP_PATH = 'images/webp/default_picture.webp';

    /**
     * Display the landing page.
     */
    public function index(HomePageContentService $homePageContentService, PageImageContentService $pageImageContentService): View
    {
        $homeContent = $homePageContentService->getPayload();

        $landingImages = $pageImageContentService->getPageImages('landing', [
            'hero_main' => [
                'jpeg' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Sekolah SMKN 1 Wringin',
            ],
            'sambutan_kepala_sekolah' => [
                'jpeg' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'SITI ANY MAYA SHULHAH, S.Sn., M.Pd., M.Sc.',
            ],
            'profil_guru' => [
                'jpeg' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Guru Mengajar',
            ],
            'profil_praktek' => [
                'jpeg' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Praktek SMK',
            ],
        ]);

        return view('landing', compact('homeContent', 'landingImages'));
    }

    /**
     * Display the profil sekolah / tentang kami page.
     */
    public function tentang(PageBuilderContentService $pageBuilderContentService): View
    {
        $profilContent = $pageBuilderContentService->getPagePayload('profil');

        return view('pages.tentang', compact('profilContent'));
    }

    /**
     * Display the jurusan detail page.
     */
    public function jurusanDetail(string $slug, PageImageContentService $pageImageContentService): View
    {
        $jurusanData = [
            'tav' => [
                'short' => 'TAV',
                'name' => 'Teknik Audio Video',
                'hero_description' => 'Teknik Audio Video terintegrasi dengan perkembangan IoT dan teknologi elektronika modern.',
                'hero_icon' => 'fa-tv',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Praktik Teknik Audio Video',
                'description' => [
                    'Teknik Audio Video (TAV) di SMKN 1 Wringin tidak hanya mempelajari sistem audio dan video konvensional, tetapi juga terintegrasi dengan perkembangan Internet of Things (IoT) dan teknologi elektronika modern. Siswa dibekali keterampilan dalam memahami rangkaian elektronika, sistem kontrol berbasis mikrokontroler, serta pengelolaan perangkat audio visual berbasis digital dan jaringan.',
                    'Pembelajaran dilakukan secara terpadu antara teori dan praktik di laboratorium, sehingga siswa mampu merancang, mengoperasikan, serta melakukan perawatan dan perbaikan sistem audio video yang adaptif terhadap perkembangan teknologi.',
                    'Lulusan TAV memiliki peluang luas di bidang industri kreatif, sistem tata suara modern, teknisi elektronika, hingga pengembangan perangkat berbasis IoT, serta berpeluang menjadi wirausaha di bidang teknologi dan multimedia.',
                ],
                'kompetensi' => [
                    'Instalasi dan pengelolaan sistem audio video',
                    'Pemrograman dasar mikrokontroler dan IoT',
                ],
                'mitra' => [
                    'Andy Service',
                    'Polytron',
                    'TOA Corporation',
                ],
                'advantages' => [
                    ['icon' => 'fa-microchip', 'title' => 'Integrasi IoT dan Elektronika', 'description' => 'Siswa tidak hanya mempelajari audio video konvensional, tetapi juga sistem kontrol mikrokontroler dan perangkat berbasis IoT.'],
                    ['icon' => 'fa-flask', 'title' => 'Teori dan Praktik Terpadu', 'description' => 'Pembelajaran dirancang seimbang antara materi kelas dan praktik laboratorium agar siap menghadapi kebutuhan industri.'],
                    ['icon' => 'fa-screwdriver-wrench', 'title' => 'Kemampuan Rancang dan Perawatan', 'description' => 'Siswa dilatih merancang, mengoperasikan, serta melakukan perawatan dan perbaikan sistem audio video digital.'],
                    ['icon' => 'fa-briefcase', 'title' => 'Peluang Karier Luas', 'description' => 'Lulusan berpeluang berkarier di industri kreatif, teknisi elektronika, pengembangan IoT, hingga wirausaha teknologi.'],
                ],
            ],
            'dkv' => [
                'short' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'hero_description' => 'DKV membekali kemampuan kreatif menyampaikan pesan melalui media visual untuk kebutuhan industri kreatif.',
                'hero_icon' => 'fa-pen-nib',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Praktik Desain Komunikasi Visual',
                'description' => [
                    'Desain Komunikasi Visual (DKV) SMKN 1 Wringin membekali siswa dengan kemampuan kreatif dalam menyampaikan pesan melalui media visual. Pembelajaran mencakup desain grafis, ilustrasi, fotografi, videografi, hingga konten digital untuk kebutuhan industri kreatif dan media sosial.',
                    'Terintegrasi dengan teknologi digital, siswa dilatih menggunakan perangkat dan software desain profesional, serta mengembangkan karya berbasis kebutuhan nyata melalui pendekatan Teaching Factory.',
                    'Lulusan DKV memiliki peluang luas sebagai desainer grafis, content creator, fotografer, videografer, hingga wirausaha di bidang industri kreatif.',
                ],
                'kompetensi' => [
                    'Desain grafis dan komunikasi visual',
                    'Produksi konten digital (foto, video, media sosial)',
                    'Editing dan pengolahan multimedia',
                ],
                'mitra' => [
                    'Curahmanis Studio',
                    'Sparkling Digital Printing',
                ],
                'advantages' => [
                    ['icon' => 'fa-palette', 'title' => 'Kreativitas Komunikasi Visual', 'description' => 'Siswa dibekali kemampuan menyampaikan pesan visual melalui desain grafis, ilustrasi, fotografi, dan videografi.'],
                    ['icon' => 'fa-photo-film', 'title' => 'Produksi Konten Digital', 'description' => 'Pembelajaran menyiapkan siswa membuat konten untuk kebutuhan industri kreatif dan media sosial secara profesional.'],
                    ['icon' => 'fa-laptop-code', 'title' => 'Software Desain Profesional', 'description' => 'Siswa terbiasa menggunakan perangkat dan software desain yang relevan dengan kebutuhan kerja di lapangan.'],
                    ['icon' => 'fa-industry', 'title' => 'Teaching Factory Nyata', 'description' => 'Karya dikembangkan berbasis kebutuhan nyata sehingga lulusan siap kerja maupun berwirausaha di industri kreatif.'],
                ],
            ],
            'tkj' => [
                'short' => 'TKJ',
                'name' => 'Teknik Komputer Jaringan',
                'hero_description' => 'TKJ membekali keterampilan jaringan, server, keamanan digital, cloud, dan IoT berbasis kebutuhan industri.',
                'hero_icon' => 'fa-network-wired',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Praktik Teknik Komputer Jaringan',
                'description' => [
                    'Teknik Komputer dan Jaringan (TKJ) di SMKN 1 Wringin membekali siswa dengan keterampilan di bidang jaringan komputer, sistem server, dan teknologi digital berbasis internet. Pembelajaran tidak hanya berfokus pada instalasi dan konfigurasi jaringan, tetapi juga mencakup pengelolaan server, keamanan jaringan (cyber security), serta pengenalan cloud dan Internet of Things (IoT).',
                    'Dengan pendekatan praktik berbasis Teaching Factory, siswa dilatih untuk mampu membangun, mengelola, dan mengamankan sistem jaringan secara profesional.',
                    'Lulusan TKJ memiliki peluang luas di bidang IT support, network administrator, teknisi jaringan, hingga wirausaha di bidang layanan teknologi informasi.',
                ],
                'kompetensi' => [
                    'Instalasi dan konfigurasi jaringan komputer',
                    'Administrasi server dan layanan jaringan',
                    'Implementasi IoT dan sistem berbasis cloud',
                ],
                'mitra' => [
                    'Telkom Indonesia',
                    'PT. Java Digital Nusantara',
                ],
                'advantages' => [
                    ['icon' => 'fa-network-wired', 'title' => 'Jaringan dan Server Terpadu', 'description' => 'Siswa mempelajari instalasi, konfigurasi jaringan, serta pengelolaan server sebagai fondasi infrastruktur IT modern.'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Fokus Keamanan Jaringan', 'description' => 'Materi cyber security membekali siswa untuk mengelola, melindungi, dan menjaga stabilitas layanan jaringan.'],
                    ['icon' => 'fa-cloud', 'title' => 'Cloud dan IoT', 'description' => 'Pembelajaran mengenalkan implementasi sistem berbasis cloud dan IoT agar kompetensi sesuai perkembangan teknologi.'],
                    ['icon' => 'fa-people-group', 'title' => 'Teaching Factory Profesional', 'description' => 'Pendekatan praktik membentuk kesiapan kerja sebagai IT support, network administrator, teknisi jaringan, maupun wirausaha IT.'],
                ],
            ],
            'tkro' => [
                'short' => 'TKRO',
                'name' => 'Teknik Kendaraan Ringan Otomotif',
                'hero_description' => 'TKRO membekali keterampilan perawatan, perbaikan, dan diagnosa kendaraan modern berbasis teknologi otomotif.',
                'hero_icon' => 'fa-car-side',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Praktik Teknik Kendaraan Ringan Otomotif',
                'description' => [
                    'Teknik Kendaraan Ringan Otomotif (TKRO) SMKN 1 Wringin membekali siswa dengan keterampilan di bidang perawatan, perbaikan, dan teknologi kendaraan modern. Pembelajaran mencakup sistem mesin, kelistrikan otomotif, hingga teknologi kendaraan berbasis injeksi dan kontrol elektronik (EFI).',
                    'Seiring perkembangan industri otomotif, siswa juga dikenalkan pada sistem kendaraan berbasis sensor dan diagnostik digital. Dengan pendekatan praktik di bengkel dan Teaching Factory, siswa dilatih bekerja sesuai standar industri.',
                    'Lulusan TKRO memiliki peluang luas sebagai teknisi otomotif, mekanik profesional, hingga wirausaha bengkel mandiri.',
                ],
                'kompetensi' => [
                    'Perawatan dan perbaikan mesin kendaraan',
                    'Sistem kelistrikan dan elektronika otomotif',
                ],
                'mitra' => [
                    'Curahmanis Studio',
                    'Sparkling Digital Printing',
                ],
                'advantages' => [
                    ['icon' => 'fa-car-battery', 'title' => 'Teknologi Otomotif Modern', 'description' => 'Siswa mempelajari sistem mesin, kelistrikan otomotif, teknologi injeksi, dan kontrol elektronik (EFI).'],
                    ['icon' => 'fa-gear', 'title' => 'Praktik Bengkel Intensif', 'description' => 'Pembelajaran berbasis praktik di bengkel dan Teaching Factory melatih ketelitian kerja sesuai standar industri.'],
                    ['icon' => 'fa-magnifying-glass-chart', 'title' => 'Diagnostik Digital', 'description' => 'Siswa dikenalkan pada sistem kendaraan berbasis sensor dan proses analisis kerusakan secara digital.'],
                    ['icon' => 'fa-store', 'title' => 'Karier dan Wirausaha', 'description' => 'Lulusan siap berkarier sebagai teknisi otomotif, mekanik profesional, atau membangun bengkel mandiri.'],
                ],
            ],
        ];

        $jurusan = $jurusanData[$slug] ?? null;

        if (! $jurusan) {
            throw new NotFoundHttpException();
        }

        $galleryFallbackTemplate = [
            [
                'slot' => 'gallery_1',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Siswa berdiskusi proyek',
                'caption' => 'Kegiatan Praktik Jurusan',
            ],
            [
                'slot' => 'gallery_2',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Menulis Kode',
                'caption' => 'Sesi Praktikum',
            ],
            [
                'slot' => 'gallery_3',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Lab Komputer',
                'caption' => 'Fasilitas Laboratorium',
            ],
            [
                'slot' => 'gallery_4',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Jaringan Server',
                'caption' => 'Pembelajaran Lapangan',
            ],
            [
                'slot' => 'gallery_5',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Kunjungan Industri',
                'caption' => 'Kunjungan Industri',
            ],
        ];

        $fallbackJurusanImages = [];

        foreach ($jurusanData as $jurusanSlug => $data) {
            $fallbackJurusanImages[$jurusanSlug.'_hero_image'] = [
                'jpeg' => $data['hero_image'],
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => $data['hero_image_alt'],
            ];

            foreach ($galleryFallbackTemplate as $item) {
                $fallbackJurusanImages[$jurusanSlug.'_'.$item['slot']] = [
                    'jpeg' => $item['image'],
                    'webp' => $item['webp'] ?? self::DEFAULT_WEBP_PATH,
                    'alt' => $item['alt'],
                ];
            }
        }

        $jurusanImageMap = $pageImageContentService->getPageImages('jurusan_detail', $fallbackJurusanImages);

        $heroKey = $slug.'_hero_image';
        $heroImage = $jurusanImageMap[$heroKey] ?? null;

        if ($heroImage) {
            $jurusan['hero_image'] = $heroImage['jpeg_url'];
            $jurusan['hero_image_webp'] = $heroImage['webp_url'];
            $jurusan['hero_image_alt'] = $heroImage['alt_text'] ?: $jurusan['hero_image_alt'];
        }

        $galleryImages = [];

        foreach ($galleryFallbackTemplate as $item) {
            $galleryKey = $slug.'_'.$item['slot'];
            $resolvedImage = $jurusanImageMap[$galleryKey] ?? null;

            $galleryImages[] = [
                'slot' => $item['slot'],
                'jpeg_url' => $resolvedImage['jpeg_url'] ?? $item['image'],
                'webp_url' => $resolvedImage['webp_url'] ?? null,
                'alt' => $resolvedImage['alt_text'] ?? $item['alt'],
                'caption' => $item['caption'],
            ];
        }

        $jurusan['gallery_images'] = $galleryImages;

        return view('pages.jurusan-detail', compact('jurusan'));
    }

    /**
     * Display the kurikulum detail page.
     */
    public function kurikulumDetail(): View
    {
        return view('pages.kurikulum-detail');
    }

    /**
     * Display the budaya positif page.
     */
    public function budayaPositif(): View
    {
        return view('pages.budaya-positif');
    }

    /**
     * Display the ekstrakurikuler page.
     */
    public function ekstrakurikuler(PageImageContentService $pageImageContentService): View
    {
        $extras = array_values($this->ekstrakurikulerCatalog());
        $fallbackSlots = [];

        foreach ($extras as $extra) {
            $fallbackSlots[$extra['image_slot']] = [
                'jpeg' => $extra['image'],
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Kegiatan '.$extra['name'],
            ];
        }

        $ekstrakurikulerImageMap = $pageImageContentService->getPageImages('ekstrakurikuler', $fallbackSlots);

        foreach ($extras as &$extra) {
            $resolvedImage = $ekstrakurikulerImageMap[$extra['image_slot']] ?? null;

            if ($resolvedImage) {
                $extra['image'] = $resolvedImage['jpeg_url'];
                $extra['image_webp'] = $resolvedImage['webp_url'];
                $extra['image_alt'] = $resolvedImage['alt_text'] ?: 'Kegiatan '.$extra['name'];
            } else {
                $extra['image_webp'] = null;
                $extra['image_alt'] = 'Kegiatan '.$extra['name'];
            }
        }
        unset($extra);

        return view('pages.ekstrakurikuler', compact('extras'));
    }

    /**
     * Display the ekstrakurikuler detail page.
     */
    public function ekstrakurikulerDetail(string $slug, PageImageContentService $pageImageContentService): View
    {
        $catalog = $this->ekstrakurikulerCatalog();
        $ekstrakurikuler = $catalog[$slug] ?? null;

        if (! $ekstrakurikuler) {
            throw new NotFoundHttpException();
        }

        $fallbackSlots = [
            $slug.'_hero_image' => [
                'jpeg' => $ekstrakurikuler['hero_image'],
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => $ekstrakurikuler['hero_image_alt'],
            ],
        ];

        foreach ($ekstrakurikuler['gallery_defaults'] as $galleryItem) {
            $fallbackSlots[$slug.'_'.$galleryItem['slot']] = [
                'jpeg' => $galleryItem['image'],
                'webp' => $galleryItem['webp'] ?? self::DEFAULT_WEBP_PATH,
                'alt' => $galleryItem['alt'],
            ];
        }

        $imageMap = $pageImageContentService->getPageImages('ekstrakurikuler_detail', $fallbackSlots);

        $heroImage = $imageMap[$slug.'_hero_image'] ?? null;

        if ($heroImage) {
            $ekstrakurikuler['hero_image'] = $heroImage['jpeg_url'];
            $ekstrakurikuler['hero_image_webp'] = $heroImage['webp_url'];
            $ekstrakurikuler['hero_image_alt'] = $heroImage['alt_text'] ?: $ekstrakurikuler['hero_image_alt'];
        }

        $galleryImages = [];

        foreach ($ekstrakurikuler['gallery_defaults'] as $galleryItem) {
            $slotKey = $slug.'_'.$galleryItem['slot'];
            $resolvedImage = $imageMap[$slotKey] ?? null;

            $galleryImages[] = [
                'slot' => $galleryItem['slot'],
                'jpeg_url' => $resolvedImage['jpeg_url'] ?? $galleryItem['image'],
                'webp_url' => $resolvedImage['webp_url'] ?? null,
                'alt' => $resolvedImage['alt_text'] ?? $galleryItem['alt'],
                'caption' => $galleryItem['caption'],
            ];
        }

        $ekstrakurikuler['gallery_images'] = $galleryImages;

        return view('pages.ekstrakurikuler-detail', compact('ekstrakurikuler'));
    }

    /**
     * Display the ppdb page.
     */
    public function ppdb(PageBuilderContentService $pageBuilderContentService): View
    {
        $ppdbContent = $pageBuilderContentService->getPagePayload('ppdb');

        return view('pages.ppdb', compact('ppdbContent'));
    }

    /**
     * Display the sarana prasarana page.
     */
    public function saranaPrasarana(): View
    {
        return view('pages.sarana-prasarana');
    }

    /**
     * Display the bursa kerja khusus page.
     */
    public function bursaKerjaKhusus(): View
    {
        return view('pages.bursa-kerja-khusus');
    }

    /**
     * Display the pembelajaran page.
     */
    public function pembelajaran(): View
    {
        return view('pages.pembelajaran');
    }

    /**
     * Display the kemitraan page.
     */
    public function kemitraan(): View
    {
        return view('pages.kemitraan');
    }

    /**
     * Display the berita page.
     */
    public function berita(NewsContentService $newsContentService): View
    {
        $payload = $newsContentService->listingPayload(request()->string('kategori')->toString() ?: null);

        return view('pages.berita', $payload);
    }

    /**
     * Display the berita detail page.
     */
    public function beritaDetail(string $slug, NewsContentService $newsContentService): View
    {
        $payload = $newsContentService->detailPayload($slug);

        if (! $payload) {
            throw new NotFoundHttpException();
        }

        return view('pages.berita-detail', $payload);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function ekstrakurikulerCatalog(): array
    {
        $catalog = [
            'pramuka' => [
                'slug' => 'pramuka',
                'image_slot' => 'ekskul_pramuka',
                'name' => 'Pramuka',
                'category' => 'Organisasi',
                'desc' => 'Bertahan Hidup & Tumbuh Tangguh di Alam Bebas',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[400px]',
                'days' => 'Jumat, Sabtu',
                'time' => '15.30 WIB',
                'color' => 'teal',
                'hero_icon' => 'fa-campground',
                'hero_description' => 'Membangun karakter disiplin, kepemimpinan, dan kemandirian melalui kegiatan lapangan yang menantang.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Pramuka SMKN 1 Wringin',
                'description' => [
                    'Ekstrakurikuler Pramuka menjadi ruang pembinaan karakter melalui kegiatan berkelompok, latihan kepemimpinan, dan penguatan tanggung jawab personal.',
                    'Siswa mengikuti latihan baris-berbaris, survival dasar, manajemen regu, hingga simulasi kegiatan sosial yang menumbuhkan jiwa gotong royong.',
                    'Melalui Pramuka, siswa dibiasakan berani mengambil keputusan, tangguh menghadapi tantangan, serta siap menjadi pribadi yang bermanfaat di lingkungan sekolah dan masyarakat.',
                ],
            ],
            'pmr' => [
                'slug' => 'pmr',
                'image_slot' => 'ekskul_pmr',
                'name' => 'Palang Merah Remaja',
                'category' => 'Sosial & Medis',
                'desc' => 'Garda Terdepan Penyelamat Nyawa',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[350px]',
                'days' => 'Rabu, Jumat',
                'time' => '16.00 WIB',
                'color' => 'rose',
                'hero_icon' => 'fa-briefcase-medical',
                'hero_description' => 'Membentuk siswa yang sigap, peduli, dan terampil dalam pertolongan pertama serta aksi kemanusiaan.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan PMR SMKN 1 Wringin',
                'description' => [
                    'PMR menjadi wadah bagi siswa yang ingin belajar kepedulian sosial sekaligus keterampilan medis dasar dalam suasana belajar yang aktif.',
                    'Materi rutin meliputi pertolongan pertama, penanganan kondisi darurat ringan, edukasi kesehatan, hingga pelatihan kesiapsiagaan bencana.',
                    'Aktivitas PMR melatih ketenangan, kecepatan respons, dan empati, sehingga siswa siap terlibat dalam kegiatan kemanusiaan di sekolah maupun masyarakat.',
                ],
            ],
            'hadrah' => [
                'slug' => 'hadrah',
                'image_slot' => 'ekskul_hadrah',
                'name' => 'Seni Hadrah',
                'category' => 'Seni & Budaya',
                'desc' => 'Harmoni Nada Sakral dan Lantunan Selawat',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[450px]',
                'days' => 'Selasa, Kamis',
                'time' => '15.30 WIB',
                'color' => 'amber',
                'hero_icon' => 'fa-drum',
                'hero_description' => 'Menguatkan nilai religius dan kekompakan melalui seni musik islami yang berirama dan penuh makna.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Seni Hadrah SMKN 1 Wringin',
                'description' => [
                    'Seni Hadrah menghadirkan pengalaman belajar musik tradisi islami yang berpadu dengan pembinaan adab dan etika berkesenian.',
                    'Siswa berlatih teknik pukulan alat hadrah, pengaturan tempo, vokal pendamping, serta kekompakan tim dalam setiap penampilan.',
                    'Selain meningkatkan kemampuan seni, kegiatan ini juga menumbuhkan rasa percaya diri tampil di depan publik dan mempererat kebersamaan antarsiswa.',
                ],
            ],
            'futsal' => [
                'slug' => 'futsal',
                'image_slot' => 'ekskul_futsal',
                'name' => 'Sepak Bola & Futsal',
                'category' => 'Olahraga',
                'desc' => 'Aksi Lapangan Hijau dan Taktik Juara',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[380px]',
                'days' => 'Senin, Rabu',
                'time' => '15.30 WIB',
                'color' => 'blue',
                'hero_icon' => 'fa-futbol',
                'hero_description' => 'Meningkatkan stamina, strategi bermain, dan mental kompetitif melalui latihan sepak bola dan futsal terstruktur.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Sepak Bola dan Futsal SMKN 1 Wringin',
                'description' => [
                    'Ekstrakurikuler ini dirancang untuk siswa yang ingin mengembangkan kemampuan teknik dasar dan strategi permainan sepak bola serta futsal.',
                    'Latihan mencakup passing, dribbling, finishing, organisasi tim, dan simulasi pertandingan untuk membangun pemahaman taktik yang baik.',
                    'Dengan pembinaan rutin, siswa tidak hanya tumbuh sebagai atlet pelajar, tetapi juga belajar sportivitas, disiplin latihan, dan kerja sama tim.',
                ],
            ],
            'basket' => [
                'slug' => 'basket',
                'image_slot' => 'ekskul_basket',
                'name' => 'Bola Basket',
                'category' => 'Olahraga',
                'desc' => 'Terbang Tinggi Cetak Tiga Angka Gemilang',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[420px]',
                'days' => 'Selasa, Kamis',
                'time' => '16.00 WIB',
                'color' => 'orange',
                'hero_icon' => 'fa-basketball',
                'hero_description' => 'Melatih kelincahan, akurasi, dan kekompakan tim untuk meraih performa terbaik di setiap pertandingan.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Bola Basket SMKN 1 Wringin',
                'description' => [
                    'Bola Basket menjadi sarana siswa mengembangkan kemampuan fisik, kontrol emosi, serta kecepatan mengambil keputusan saat bermain.',
                    'Program latihan fokus pada fundamental basket seperti dribble, passing, shooting, rebound, dan koordinasi antarpemain.',
                    'Melalui sesi latihan dan sparing, siswa dibimbing membangun mental juara, komunikasi efektif, dan semangat kompetisi yang sehat.',
                ],
            ],
            'voli' => [
                'slug' => 'voli',
                'image_slot' => 'ekskul_voli',
                'name' => 'Bola Voli',
                'category' => 'Olahraga',
                'desc' => 'Lompatan Akurat Menuju Kemenangan Tim',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[360px]',
                'days' => 'Senin, Rabu',
                'time' => '16.00 WIB',
                'color' => 'cyan',
                'hero_icon' => 'fa-volleyball',
                'hero_description' => 'Mengasah refleks, teknik, dan koordinasi permainan untuk menciptakan tim voli yang solid dan tangguh.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Bola Voli SMKN 1 Wringin',
                'description' => [
                    'Ekstrakurikuler Bola Voli membuka ruang bagi siswa untuk berkembang dalam olahraga tim yang menuntut konsentrasi dan koordinasi tinggi.',
                    'Siswa mempelajari teknik servis, passing, smash, block, dan rotasi posisi melalui latihan yang konsisten dan bertahap.',
                    'Kegiatan ini membangun daya juang, semangat kolaborasi, serta ketahanan fisik yang berguna dalam aktivitas sekolah dan kompetisi.',
                ],
            ],
            'esports' => [
                'slug' => 'esports',
                'image_slot' => 'ekskul_esports',
                'name' => 'E-Sports Club',
                'category' => 'E-Sports',
                'desc' => 'Adu Strategi Digital di Arena Profesional',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[400px]',
                'days' => 'Jumat',
                'time' => '14.00 WIB',
                'color' => 'purple',
                'hero_icon' => 'fa-gamepad',
                'hero_description' => 'Mendorong siswa berpikir strategis, cepat, dan kolaboratif lewat pembinaan e-sports yang sehat dan terarah.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan E-Sports Club SMKN 1 Wringin',
                'description' => [
                    'E-Sports Club mengembangkan minat siswa di bidang game kompetitif dengan pendekatan disiplin latihan dan sportivitas digital.',
                    'Materi pembinaan mencakup strategi tim, komunikasi in-game, manajemen waktu, analisis permainan, dan etika berkompetisi.',
                    'Dengan pendampingan yang tepat, siswa dapat membangun potensi prestasi di e-sports sekaligus menjaga keseimbangan akademik dan karakter.',
                ],
            ],
            'tari-vokal' => [
                'slug' => 'tari-vokal',
                'image_slot' => 'ekskul_tari_vokal',
                'name' => 'Seni Tari & Vokal',
                'category' => 'Seni & Budaya',
                'desc' => 'Ekspresikan Jiwa Lewat Gerak dan Nada',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[480px]',
                'days' => 'Rabu, Sabtu',
                'time' => '15.00 WIB',
                'color' => 'pink',
                'hero_icon' => 'fa-music',
                'hero_description' => 'Menyalurkan ekspresi artistik melalui latihan tari dan vokal yang kreatif, disiplin, dan percaya diri.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Seni Tari dan Vokal SMKN 1 Wringin',
                'description' => [
                    'Seni Tari dan Vokal menjadi wadah siswa mengekspresikan diri melalui pertunjukan, koreografi, dan olah vokal yang terarah.',
                    'Kegiatan rutin mencakup latihan teknik dasar, penjiwaan, pemanasan fisik, pengaturan napas, serta persiapan panggung.',
                    'Ekskul ini membantu siswa membangun kepercayaan diri, kemampuan tampil di publik, serta apresiasi terhadap seni dan budaya.',
                ],
            ],
            'vm-media' => [
                'slug' => 'vm-media',
                'image_slot' => 'ekskul_vm_media',
                'name' => 'VM Media',
                'category' => 'Teknologi',
                'desc' => 'Rekam Momen & Ciptakan Karya Visual',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[380px]',
                'days' => 'Kamis',
                'time' => '15.30 WIB',
                'color' => 'emerald',
                'hero_icon' => 'fa-photo-film',
                'hero_description' => 'Membekali siswa kemampuan produksi konten foto dan video untuk kebutuhan dokumentasi dan publikasi sekolah.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan VM Media SMKN 1 Wringin',
                'description' => [
                    'VM Media berfokus pada pengembangan keterampilan dokumentasi visual, mulai dari pengambilan gambar hingga proses editing.',
                    'Siswa belajar framing, pencahayaan, storytelling visual, editing dasar, dan manajemen publikasi konten acara sekolah.',
                    'Melalui kegiatan ini, siswa membangun portofolio kreatif sekaligus pengalaman kerja tim dalam proyek media yang nyata.',
                ],
            ],
            'sains-club' => [
                'slug' => 'sains-club',
                'image_slot' => 'ekskul_sains_club',
                'name' => 'Sains Club',
                'category' => 'Akademik',
                'desc' => 'Menembus Batas Logika & Inovasi Sains',
                'image' => self::DEFAULT_JPEG_PATH,
                'height' => 'h-[400px]',
                'days' => 'Selasa',
                'time' => '15.30 WIB',
                'color' => 'indigo',
                'hero_icon' => 'fa-flask-vial',
                'hero_description' => 'Mengajak siswa berpikir kritis dan eksperimental melalui riset sederhana serta proyek sains terapan.',
                'hero_image' => self::DEFAULT_JPEG_PATH,
                'hero_image_alt' => 'Kegiatan Sains Club SMKN 1 Wringin',
                'description' => [
                    'Sains Club menjadi ruang eksplorasi bagi siswa yang tertarik pada eksperimen, logika ilmiah, dan inovasi berbasis data.',
                    'Program kegiatan meliputi percobaan laboratorium, diskusi fenomena ilmiah, pembuatan prototipe sederhana, dan presentasi hasil riset.',
                    'Siswa dilatih untuk berpikir sistematis, melakukan observasi akurat, dan menyusun solusi kreatif terhadap masalah nyata.',
                ],
            ],
        ];

        foreach ($catalog as $slug => $item) {
            $catalog[$slug]['gallery_defaults'] = $this->ekstrakurikulerGalleryTemplate($item['name']);
        }

        return $catalog;
    }

    /**
     * @return array<int, array{slot:string,image:string,alt:string,caption:string}>
     */
    private function ekstrakurikulerGalleryTemplate(string $name): array
    {
        return [
            [
                'slot' => 'gallery_1',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Kegiatan tim '.$name,
                'caption' => 'Latihan Rutin '.$name,
            ],
            [
                'slot' => 'gallery_2',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Sesi pembinaan '.$name,
                'caption' => 'Sesi Pembinaan',
            ],
            [
                'slot' => 'gallery_3',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Kolaborasi siswa '.$name,
                'caption' => 'Kolaborasi Tim',
            ],
            [
                'slot' => 'gallery_4',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Proyek kegiatan '.$name,
                'caption' => 'Proyek Kegiatan',
            ],
            [
                'slot' => 'gallery_5',
                'image' => self::DEFAULT_JPEG_PATH,
                'webp' => self::DEFAULT_WEBP_PATH,
                'alt' => 'Dokumentasi kegiatan '.$name,
                'caption' => 'Dokumentasi Kegiatan',
            ],
        ];
    }
}
