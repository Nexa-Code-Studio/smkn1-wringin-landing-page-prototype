<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSiswaAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('siswa')->check()) {
            return redirect()->route('siswa.berita.index');
        }

        return $next($request);
    }
}
