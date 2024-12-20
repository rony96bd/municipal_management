<?php

use App\Http\Controllers\front\frontController;
use App\Http\Controllers\front\SearchController;
use Illuminate\Support\Facades\Route;

//==== front.php ======//

Route::get('/', [frontController::class, 'index'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->name('search');
