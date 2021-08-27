<?php

use Illuminate\Support\Facades\Route;
use Internexus\Larapid\Http\LarapidController;

/*
|--------------------------------------------------------------------------
| CMS Web Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cms')->middleware('web')->group(function() {
    Route::get('/{entity}', [LarapidController::class, 'index'])->name('larapid.index');
    Route::post('/{entity}', [LarapidController::class, 'store'])->name('larapid.store');
    Route::get('/{entity}/create', [LarapidController::class, 'create'])->name('larapid.create');
    Route::get('/{entity}/{id}', [LarapidController::class, 'edit'])->name('larapid.edit');
    Route::put('/{entity}/{id}', [LarapidController::class, 'update'])->name('larapid.update');
    Route::delete('/{entity}/{id}', [LarapidController::class, 'destroy'])->name('larapid.destroy');
});
