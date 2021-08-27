<?php

namespace Internexus\Larapid;

use Internexus\Larapid\Facades\Larapid as Facade;
use Internexus\Larapid\Larapid;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
            return new Larapid();
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
            return Facade::resolveEntity($entity);
        });

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'larapid');
    }
}
