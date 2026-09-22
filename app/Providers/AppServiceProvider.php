<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        // Kada ASSET_URL nije postavljen u .env, a APP_ENV je production,
        // Laravel pretpostavlja da su asseti na korijenu domene.
        // Na serverima gdje document root nije public/, URL treba /public prefiks.
        // Ovo automatski ispravlja asset() URL-ove bez potrebe za promjenom .env na serveru.
        if (!env('ASSET_URL') && app()->environment('production')) {
            $appUrl = rtrim(config('app.url'), '/');
            app('config')->set('app.asset_url', $appUrl . '/public');
        }

        // @assetv('site/js/main.js') -> .../site/js/main.js?v=1758557376
        //
        // Broj je vrijeme zadnje izmjene fajla. Cim se CSS ili JS promijeni,
        // mijenja se i adresa, pa preglednici odmah skidaju novu verziju
        // umjesto da do mjesec dana serviraju staru iz kesa.
        Blade::directive('assetv', function ($expression) {
            return "<?php
                \$__assetv_path = {$expression};
                \$__assetv_file = public_path(\$__assetv_path);
                echo e(asset(\$__assetv_path) . (is_file(\$__assetv_file) ? '?v=' . filemtime(\$__assetv_file) : ''));
            ?>";
        });
    }
}

