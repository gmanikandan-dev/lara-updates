<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Services\BindService', function ($app) {
            return new \App\Services\MyService();
        });

        $this->app->singleton('App\Services\SingletonService', function ($app) {
            return new \App\Services\MyService();
        });

        $this->app->scoped('App\Services\ScopedService', function ($app) {
            return new \App\Services\MyService();
        });

        $myServiceInstance = new \App\Services\MyService();
        $this->app->instance('App\Services\InstanceService', $myServiceInstance);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
