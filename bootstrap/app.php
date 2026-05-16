<?php

use App\Http\Middleware\AuthenticateSiswa;
use App\Http\Middleware\EnsureSiswaCanSubmitNews;
use App\Http\Middleware\RedirectIfSiswaAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->alias([
            'auth.siswa' => AuthenticateSiswa::class,
            'guest.siswa' => RedirectIfSiswaAuthenticated::class,
            'siswa.can-submit-news' => EnsureSiswaCanSubmitNews::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
