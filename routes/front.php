<?php

use App\Http\Controllers\front\frontController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/web.php';

//==== front.php ======//
Route::get('/', [frontController::class, 'index'])->name('homepage');
