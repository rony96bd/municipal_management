<?php

use App\Http\Controllers\dash\dashboardController;
use App\Http\Controllers\dash\OfficoalsController;
use App\Http\Controllers\dash\PageController;
use App\Http\Controllers\dash\RepresntativesController;
use App\Http\Controllers\dash\ServiceController;
use App\Http\Controllers\dash\StuffsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//==== dashboard.php ======//

require __DIR__ . '/auth.php';
Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {
        // Pages Routes
        Route::get('/pages', [PageController::class, 'pagelist'])->name('pages');
        Route::get('/create-page', [PageController::class, 'createpage'])->name('create-page');
        Route::post('/create-page', [PageController::class, 'store'])->name('store-page');
        Route::get('/edit-page/{id}', [PageController::class, 'edit'])->name('edit-page');
        Route::post('/edit-page/{id}', [PageController::class, 'update'])->name('update-page');
        Route::delete('/delete-page/{id}', [PageController::class, 'destroy'])->name('delete-page');
        // officials
        Route::get('/officials', [OfficoalsController::class, 'officialslist'])->name('officialslist');
        Route::get('/create-official', [OfficoalsController::class, 'createofficial'])->name('create-official');
        Route::post('/create-official', [OfficoalsController::class, 'store'])->name('store-official');
        Route::get('/edit-official/{id}', [OfficoalsController::class, 'edit'])->name('edit-official');
        Route::post('/edit-official/{id}', [OfficoalsController::class, 'update'])->name('update-official');
        Route::delete('/delete-official/{id}', [OfficoalsController::class, 'destroy'])->name('delete-official');
        // Stuffs
        Route::get('/stuffs', [StuffsController::class, 'stuffslist'])->name('stuffslist');
        Route::get('/create-stuff', [StuffsController::class, 'createstuff'])->name('create-stuff');
        Route::post('/create-stuff', [StuffsController::class, 'store'])->name('store-stuff');
        Route::get('/edit-stuff/{id}', [StuffsController::class, 'edit'])->name('edit-stuff');
        Route::post('/edit-stuff/{id}', [StuffsController::class, 'update'])->name('update-stuff');
        Route::delete('/delete-stuff/{id}', [StuffsController::class, 'destroy'])->name('delete-stuff');
        // Representatives
        Route::get('/representatives', [RepresntativesController::class, 'representativesslist'])->name('representativeslist');
        Route::get('/create-representative', [RepresntativesController::class, 'createsrepresentative'])->name('create-representative');
        Route::post('/create-representative', [RepresntativesController::class, 'store'])->name('store-representative');
        Route::get('/edit-representative/{id}', [RepresntativesController::class, 'edit'])->name('edit-representative');
        Route::post('/edit-representative/{id}', [RepresntativesController::class, 'update'])->name('update-representative');
        Route::delete('/delete-representative/{id}', [RepresntativesController::class, 'destroy'])->name('delete-representative');
        // Services
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/create-service', [ServiceController::class, 'createservice'])->name('create-service');
        Route::post('/create-service', [ServiceController::class, 'store'])->name('store-service');
        Route::get('/edit-service/{service_id}', [ServiceController::class, 'edit'])->name('edit-service');
        Route::post('/edit-service/{service_id}', [ServiceController::class, 'update'])->name('update-service');
        Route::delete('/delete-service/{id}', [ServiceController::class, 'destroy'])->name('delete-service');
        Route::get('/service/configure/{page_url}', [ServiceController::class, 'configure'])->name('service-configure');
        Route::post('/service/configure/{page_url}', [ServiceController::class, 'storesingleservice'])->name('configure-single-service-store');
        Route::get('/service/item/configure/{id}', [ServiceController::class, 'editsingleserviceitem'])->name('edit-single-service-item');
    });
});
