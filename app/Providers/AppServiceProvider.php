<?php

namespace App\Providers;

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
    }
}
