<?php

namespace App\Providers;

use App\Models\JenisPaket;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();

        // Set default timezone to WIB (Asia/Jakarta)
        date_default_timezone_set('Asia/Jakarta');

        // Share jenisPakets with sidebar view
        View::composer('layouts.partials.sidebar', function ($view) {
            $view->with('jenisPakets', JenisPaket::where('is_active', true)->get());
        });
    }
}
