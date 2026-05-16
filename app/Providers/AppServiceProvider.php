<?php

namespace App\Providers;

use App\Services\HomePageContentService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('graduation-check', function (Request $request) {
            return Limit::perMinute(50)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 menit.',
                    ], 429);
                });
        });

        view()->composer('partials.footer', function ($view) {
            $view->with('homeContent', app(HomePageContentService::class)->getPayload());
        });
    }
}
