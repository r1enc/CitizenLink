<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon; // Import Carbon buat jam

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
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        // Fix masalah key length string database lama
        Schema::defaultStringLength(191);

        // 🔥 FIX TIMEZONE: PAKSA KE ASIA/JAKARTA (WIB) 🔥
        // Ini biar jam di laporan, timeline, dan created_at sesuai real life kamu
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');
    }
}