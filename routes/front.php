<?php

use App\Http\Controllers\front\frontController;
use App\Http\Controllers\front\SearchController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/web.php';

//==== front.php ======//
Route::get('/', [frontController::class, 'index'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/officers', [frontController::class, 'officers'])->name('officers');
Route::get('/officer/{page_url}', [frontController::class, 'officerDetails'])->name('officer-details');
Route::get('/stuffs', [frontController::class, 'stuffs'])->name('stuffs');
Route::get('/stuff/{page_url}', [frontController::class, 'stuffDetails'])->name('stuff-details');
Route::get('/representatives', [frontController::class, 'representatives'])->name('representatives');
Route::get('/representative/{page_url}', [frontController::class, 'representativeDetails'])->name('representative-details');
Route::get('/page/{page_url}', [frontController::class, 'singlepage'])->name('page-details');
