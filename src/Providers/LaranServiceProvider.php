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
        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/laran'),
        ], 'laran-assets');
    }
}
