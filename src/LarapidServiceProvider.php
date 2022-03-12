<?php

namespace Internexus\Larapid;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Internexus\Larapid\Http\Middleware\HandleInertiaRequests;
use Internexus\Larapid\Facades\Larapid as Facade;
use Internexus\Larapid\Larapid;

class LarapidServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Larapid::class, function ($app) {
            return new Larapid($app['config']['larapid'] ?? []);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('entity', function ($entity) {
            return Facade::guestEntity($entity);
        });

        $this->app->register(InertiaServiceProvider::class);
        $this->app->router->aliasMiddleware('larapid.inertia', HandleInertiaRequests::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'larapid');

        $this->publishes([
            __DIR__.'/../config/larapid.php' => config_path('larapid.php'),
            __DIR__.'/../public' => public_path('vendor/larapid'),
        ], 'larapid');
    }
}
