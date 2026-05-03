<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPhotoZipImport;
use App\Models\GraduationSetting;
use App\Models\ImportJob;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
        return view('graduation.admin');
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
}
