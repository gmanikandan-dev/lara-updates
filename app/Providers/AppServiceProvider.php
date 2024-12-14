<?php

namespace App\Providers;

use App\Classes\ColorFilter;
use App\Classes\CpuReport;
use App\Classes\Firewall;
use App\Classes\MemoryReport;
use App\Classes\OppoMobile;
use App\Classes\ReportAnalyzer;
use App\Classes\SizeFilter;
use App\Http\Controllers\PhotoController;
use App\Interfaces\Camera;
use App\Interfaces\Filter;
use App\Services\MyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Services\BindService', function ($app) {
            return new MyService;
        });

        $this->app->singleton('App\Services\SingletonService', function ($app) {
            return new MyService;
        });

        $this->app->scoped('App\Services\ScopedService', function ($app) {
            return new MyService;
        });

        $myServiceInstance = new MyService;
        $this->app->instance('App\Services\InstanceService', $myServiceInstance);

        /* binding primitives */
        $this->app->when(PhotoController::class)
            ->needs(Camera::class)
            ->give(OppoMobile::class);

        $this->app->when(Firewall::class)
            ->needs(Filter::class)
            ->give(function ($app) {
                return [
                    $app->make(SizeFilter::class),
                    $app->make(ColorFilter::class),
                ];
            });

        /* binding tagged */
        $this->app->tag([CpuReport::class, MemoryReport::class], 'reports');

        $this->app->bind(ReportAnalyzer::class, function (Application $app) {
            return new ReportAnalyzer($app->tagged('reports'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
