<?php

namespace App\Providers;

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
        RateLimiter::for('registro-dispositivo', function (Request $request) {
            $identificador = $request->hasSession()
                ? $request->session()->getId()
                : ($request->ip() . '|' . $request->userAgent());

            return Limit::perMinute(2)
                ->by($identificador)
                ->response(function (Request $request, array $headers) {
                    return back()
                        ->withErrors(['limite' => 'Demasiados intentos desde este dispositivo. Por favor espera 1 minuto para volver a intentar.'])
                        ->withInput();
                });
        });
    }
}
