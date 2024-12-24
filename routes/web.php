<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dash\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dash\MenuBuilderController;

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
    Route::group(['as' => 'menus.', 'prefix' => 'menus/{id}'], function () {
        Route::get('builder', [MenuBuilderController::class, 'index'])->name('builder');
    });
});
