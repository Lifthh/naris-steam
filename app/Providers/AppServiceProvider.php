<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tambahkan baris ini
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Kode View::composer kamu yang sudah ada...
        View::composer('*', function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('storeName', \App\Models\Setting::get('store_name', 'NARIS STEAM'));
            }
        });
    }
}
