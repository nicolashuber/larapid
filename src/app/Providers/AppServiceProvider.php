<?php

namespace App\Providers;

use App\Larapid\Facades\Larapid;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Larapid::entities([
            \App\Larapid\Entities\PostEntity::class,
            \App\Larapid\Entities\UserEntity::class,
            \App\Larapid\Entities\CategoryEntity::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
