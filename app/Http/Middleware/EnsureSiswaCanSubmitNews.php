<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiswaCanSubmitNews
{
    public function handle(Request $request, Closure $next): Response
    {
        $siswa = auth('siswa')->user();

        abort_unless($siswa && $siswa->can_submit_news, 403, 'Akun siswa ini belum diberi izin untuk mengirim berita.');

        return $next($request);
    }
}
