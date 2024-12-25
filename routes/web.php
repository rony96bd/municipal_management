<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dash\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dash\MenuBuilderController;

Route::get('/test', function () {
    return menu('main-menu');
});

require __DIR__ . '/auth.php';
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menus
    Route::resource('menus', MenuController::class)->except(['show'])->names(['index' => 'menus.index', 'create' => 'menus.create', 'store' => 'menus.store', 'edit' => 'menus.edit', 'update' => 'menus.update', 'destroy' => 'menus.destroy']);

    Route::group(['as' => 'menus.', 'prefix' => 'menus/{id}/'], function () {
        // Menu Builder
        Route::post('order', [MenuBuilderController::class, 'order'])->name('order');
        Route::get('builder', [MenuBuilderController::class, 'index'])->name('builder');
        // Menu Item
        Route::group(['as' => 'item.', 'prefix' => 'item'], function () {
            Route::get('/create', [MenuBuilderController::class, 'itemCreate'])->name('create');
            Route::post('/store', [MenuBuilderController::class, 'itemStore'])->name('store');
            Route::get('/{itemId}/edit', [MenuBuilderController::class, 'itemEdit'])->name('edit');
            Route::put('/{itemId}/update', [MenuBuilderController::class, 'itemUpdate'])->name('update');
            Route::delete('/{itemId}/destroy', [MenuBuilderController::class, 'itemDestroy'])->name('destroy');
        });
    });
});
