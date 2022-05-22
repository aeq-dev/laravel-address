<?php

namespace Bkfdev\Addressable;

use Bkfdev\Addressable\Models\Address;
use Illuminate\Support\ServiceProvider;

class LaravelAddressServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-address.php', 'laravel-address');

        // Register the service the package provides.
        $this->app->singleton('laravel-address.address', config('laravel-address.models.address'));

        if (config('laravel-address.models.address') !== Address::class) {
            $this->app->alias('laravel-address.models.address', Address::class);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-address'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/laravel-address.php' => config_path('laravel-address.php'),
        ], 'laravel-address.config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
