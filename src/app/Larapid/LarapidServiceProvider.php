<?php

namespace App\Larapid;

use App\Larapid\Facades\Larapid as FacadesLarapid;
use App\Larapid\Larapid;
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
            return FacadesLarapid::resolveEntity($entity);
        });

        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'larapid');
    }
}
