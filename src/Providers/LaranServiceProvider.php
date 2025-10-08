<?php

namespace ErfanMasboogh\Laran\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use ErfanMasboogh\Laran\Rule\ValidMobile;
use ErfanMasboogh\Laran\Console\Commands\CreateDatatableCommand;

class LaranServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\ErfanMasboogh\Laran\Providers\LaranValidationServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Helpers
        require_once __DIR__ . '/../Helpers/Functions.php';

        
        // Loads and Merges
        $this->loadTranslationsFrom(__DIR__ . '/../../lang');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laran');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laran.php', 'laran');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laranMenu.php', 'laranMenu');


        // Publishes
        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/laran'),
        ], 'laran-assets');
        $this->publishes([
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
        ]);
        $this->publishes([
            __DIR__ . '/../../config' => config_path(),
        ]);

        // Auth
        $laranAuth = config('laran.auth');
        config(['auth.guards.manager' => $laranAuth['guards']['manager']]);
        config(['auth.providers.managers' => $laranAuth['providers']['managers']]);
        
        // Commands
        $this->commands([
            CreateDatatableCommand::class,
        ]);
    }
}
