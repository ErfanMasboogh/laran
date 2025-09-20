<?php

namespace ErfanMasboogh\Laran\Providers;

use Illuminate\Support\ServiceProvider;

class LaranServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once __DIR__ . '/../Helpers/Functions.php';

        $this->loadTranslationsFrom(__DIR__ . '/../../lang');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laran');
        $this->mergeConfigFrom(__DIR__.'/../../config/laran.php', 'laran');


        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/laran'),
        ], 'laran-assets');
        $this->publishes([
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
        ]);


        $laranAuth = config('laran.auth');
        config(['auth.guards.manager' => $laranAuth['guards']['manager']]);
        config(['auth.providers.managers' => $laranAuth['providers']['managers']]);
    }
}
