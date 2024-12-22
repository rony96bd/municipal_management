<?php

use App\Http\Controllers\dash\dashboardController;
use App\Http\Controllers\dash\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//==== dashboard.php ======//

require __DIR__ . '/auth.php';
Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pages Routes
    Route::get('/pages', [PageController::class, 'pagelist'])->name('pages');
    Route::get('/create-page', [PageController::class, 'createpage'])->name('create-page');
    Route::post('/create-page', [PageController::class, 'store'])->name('store-page');
    Route::get('/edit-page/{id}', [PageController::class, 'edit'])->name('edit-page');
    Route::post('/edit-page/{id}', [PageController::class, 'update'])->name('update-page');
    Route::delete('/delete-page/{id}', [PageController::class, 'destroy'])->name('delete-page');
});
