<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LocationIQService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LocationIQService::class, function ($app) {
            return new LocationIQService();
        });
        $this->app->bind(\App\Services\EventService::class);
        $this->app->bind(\App\Services\WeatherService::class);
        $this->app->bind(\App\Services\ImageService::class);
        $this->app->bind(\App\Services\EmailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
