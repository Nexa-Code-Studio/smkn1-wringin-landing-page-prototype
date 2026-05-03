<?php

namespace App\Http\Controllers;

use App\Models\GraduationSetting;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GraduationController extends Controller
{
    public function index()
    {
        $graduationSetting = GraduationSetting::latest()->first();

        if (!$graduationSetting) {
            $graduationSetting = new GraduationSetting([
                'angkatan' => '2026',
                'lulusan' => '2026',
                'tanggal_pengumuman' => '2026-05-06',
                'jam_pengumuman' => '10:00',
            ]);
        }

        $announcementAt = $this->announcementDateTime($graduationSetting);
        $countdownTarget = $announcementAt->toIso8601String();

        return view('graduation.index', compact('graduationSetting', 'countdownTarget'));
    }

    public function checkStatus(Request $request)
    {
        $graduationSetting = GraduationSetting::latest()->first();
        $announcementAt = $this->announcementDateTime($graduationSetting);

        if (now('Asia/Jakarta')->lt($announcementAt)) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman kelulusan belum dibuka.',
                'opens_at' => $announcementAt->toIso8601String(),
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nisn' => ['required', 'regex:/^[0-9]{10}$/'],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.regex' => 'Format NISN tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Input tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $nisn = trim($validator->validated()['nisn']);

        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $statusNormalized = strtoupper(trim((string) ($siswa->status_kelulusan ?? '')));

        if ($statusNormalized === 'LULUS') {
            $statusLabel = 'LULUS';
        } elseif ($statusNormalized === 'TIDAK LULUS') {
            $statusLabel = 'TIDAK LULUS';
        } else {
            $statusLabel = 'BELUM ADA';
        }

        $tanggalLahir = $siswa->tanggal_lahir?->format('d F Y');
        $ttl = trim(($siswa->tempat_lahir ?: '-') . ', ' . ($tanggalLahir ?: '-'));
        $foto = $siswa->photoUrl()
            ?: 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama ?: 'Siswa') . '&background=1E5460&color=fff&size=200&font-size=0.33';

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan.',
            'data' => [
                'nama' => $siswa->nama,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->kelas,
                'ttl' => $ttl,
                'status' => $statusLabel,
                'photo' => $foto,
            ],
        ]);
    }

    private function announcementDateTime(?GraduationSetting $setting): Carbon
    {
        $date = $setting?->tanggal_pengumuman?->format('Y-m-d') ?? '2026-05-06';
        $time = $setting?->jam_pengumuman ? substr($setting->jam_pengumuman, 0, 5) : '10:00';

        return Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time, 'Asia/Jakarta');
    }
}
