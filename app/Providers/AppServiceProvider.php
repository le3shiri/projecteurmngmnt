<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // On shared hosting (like Hostinger), dynamically bind public path if public_html is used
        $this->app->bind('path.public', function () {
            if (isset($_SERVER['DOCUMENT_ROOT']) && is_dir($_SERVER['DOCUMENT_ROOT']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/index.php')) {
                return $_SERVER['DOCUMENT_ROOT'];
            }
            if (is_dir(base_path('../public_html'))) {
                return base_path('../public_html');
            }
            if (is_dir(base_path('public_html'))) {
                return base_path('public_html');
            }
            return base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce HTTPS when in production, on SSL, or behind Hostinger reverse proxy
        if (config('app.env') === 'production' || 
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (request()->header('x-forwarded-proto') === 'https') ||
            request()->isSecure()) {
            URL::forceScheme('https');
        }
    }
}
