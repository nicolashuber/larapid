<?php

use Illuminate\Support\Facades\Route;
use Internexus\Larapid\Http\Controllers\DataController;
use Internexus\Larapid\Http\Controllers\LarapidController;
use Internexus\Larapid\Http\Controllers\LoginController;
use Internexus\Larapid\Http\Controllers\MediaController;
use Internexus\Larapid\Http\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| CMS Web Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cms')->middleware(['web', 'larapid.inertia'])->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('larapid.login');
    Route::post('/login', [LoginController::class, 'login'])->name('larapid.login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('larapid.logout');

    Route::middleware(Authenticate::class)->group(function () {
        Route::post('/media/{mediaGroup?}', [MediaController::class, 'store']);

        Route::get('/data/{entity}/search', [DataController::class, 'search'])->name('larapid.data.search');

        Route::get('/', [LarapidController::class, 'dashboard'])->name('larapid.dash');
        Route::get('/{entity}/create', [LarapidController::class, 'create'])->name('larapid.create');
        Route::get('/{entity}/{id}/detail', [LarapidController::class, 'detail'])->name('larapid.detail');
        Route::get('/{entity}/{id}/attach', [LarapidController::class, 'attach'])->name('larapid.attach');
        Route::post('/{entity}/{id}/attach', [LarapidController::class, 'postAttach'])->name('larapid.attach');
        Route::get('/{entity}/{id}', [LarapidController::class, 'edit'])->name('larapid.edit');
        Route::put('/{entity}/{id}', [LarapidController::class, 'update'])->name('larapid.update');
        Route::get('/{entity}', [LarapidController::class, 'index'])->name('larapid.index');
        Route::post('/{entity}', [LarapidController::class, 'store'])->name('larapid.store');
        Route::delete('/{entity}/{id}', [LarapidController::class, 'destroy'])->name('larapid.destroy');
    });
});
