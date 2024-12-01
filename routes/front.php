<?php

use App\Http\Controllers\front\frontController;
use Illuminate\Support\Facades\Route;

//==== front.php ======//

Route::get('/', [frontController::class, 'index'])->name('homepage');
