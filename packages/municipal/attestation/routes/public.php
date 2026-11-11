<?php

use Illuminate\Support\Facades\Route;
use Municipal\Attestation\Http\Controllers\Front\ApplyController;
use Municipal\Attestation\Http\Controllers\Front\TrackController;
use Municipal\Attestation\Http\Controllers\Front\VerifyController;

Route::get('/', [ApplyController::class, 'index'])->name('apply.index');
Route::get('/apply/{type:slug}', [ApplyController::class, 'show'])->name('apply.show');
Route::post('/apply/{type:slug}', [ApplyController::class, 'store'])->name('apply.store');
Route::get('/confirmation/{tracking}', [ApplyController::class, 'confirmation'])->name('apply.confirmation');

Route::get('/track', [TrackController::class, 'index'])->name('track.index');
Route::post('/track', [TrackController::class, 'track'])->name('track.track');

Route::get('/verify/{code}', [VerifyController::class, 'show'])->name('verify.show');
