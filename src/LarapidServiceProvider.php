<?php

namespace Internexus\Larapid;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Internexus\Larapid\Http\Middleware\HandleInertiaRequests;
use Internexus\Larapid\Facades\Larapid as Facade;
use Internexus\Larapid\Larapid;
use Internexus\Larapid\Models\Media;
use Internexus\Larapid\Models\MediaGroup;
use Internexus\Larapid\Services\Media\Contracts\MediaServiceContract;
use Internexus\Larapid\Services\Media\ImageProcessService;
use Internexus\Larapid\Services\Media\MediaService;
use Intervention\Image\ImageManager;

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

        $this->app->singleton(MediaServiceContract::class, function ($app) {
            $config = $app['config']['larapid'];

            return new MediaService(
                $config,
                new Media(),
                new MediaGroup(),
                new ImageProcessService(
                    new ImageManager(['driver' => $config['image_driver'] ?? 'gd'])
                )
            );
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
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations', 'larapid');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'larapid');

        $this->publishes([
            __DIR__.'/../config/larapid.php' => config_path('larapid.php'),
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/larapid'),
            __DIR__.'/../public' => public_path('vendor/larapid'),
        ], 'larapid');
    }
}
