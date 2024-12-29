<?php

use App\Http\Controllers\developers\DevelopersController;
use App\Http\Controllers\front\FrontController;
use Illuminate\Support\Facades\Route;

//==== developers.php ======//
Route::get('css', [DevelopersController::class, 'css'])->name('css');
Route::get('custom-functions', [DevelopersController::class, 'customfunctions'])->name('custom-function');
