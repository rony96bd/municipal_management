<?php

use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\SearchController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/web.php';

//==== front.php ======//
Route::get('/', [FrontController::class, 'index'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/officers', [FrontController::class, 'officers'])->name('officers');
Route::get('/notices', [FrontController::class, 'notices'])->name('notices');
Route::get('/officer/{page_url}', [FrontController::class, 'officerDetails'])->name('officer-details');
Route::get('/notice/{page_url}', [FrontController::class, 'noticeDetails'])->name('notice-details');
Route::get('/stuffs', [FrontController::class, 'stuffs'])->name('stuffs');
Route::get('/stuff/{page_url}', [FrontController::class, 'stuffDetails'])->name('stuff-details');
Route::get('/representatives', [FrontController::class, 'representatives'])->name('representatives');
Route::get('/representative/{page_url}', [FrontController::class, 'representativeDetails'])->name('representative-details');
Route::get('/page/{page_url}', [FrontController::class, 'singlepage'])->name('page-details');
