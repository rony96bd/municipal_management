<?php

use App\Http\Controllers\front\frontController;
use App\Http\Controllers\front\SearchController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/web.php';

//==== front.php ======//
Route::get('/', [frontController::class, 'index'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/officers', [frontController::class, 'officers'])->name('officers');
Route::get('/officers/{page_url}', [frontController::class, 'officerDetails'])->name('officer-details');
Route::get('/representatives', [frontController::class, 'representatives'])->name('representatives');
Route::get('/representatives/{page_url}', [frontController::class, 'representativeDetails'])->name('representative-details');
