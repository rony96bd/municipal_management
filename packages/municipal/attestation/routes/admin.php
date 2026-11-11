<?php

use Illuminate\Support\Facades\Route;
use Municipal\Attestation\Http\Controllers\Admin\ApplicationController;
use Municipal\Attestation\Http\Controllers\Admin\CertificateController;
use Municipal\Attestation\Http\Controllers\Admin\ReportController;
use Municipal\Attestation\Http\Controllers\Admin\SignatoryController;
use Municipal\Attestation\Http\Controllers\Admin\TypeController;

// Overview / Landing
Route::get('/', [ApplicationController::class, 'dashboard'])->name('index');

// Certificate Types CRUD
Route::resource('types', TypeController::class)->except(['show'])->names('types');

// Signatories CRUD
Route::resource('signatories', SignatoryController::class)->except(['show'])->names('signatories');

// Citizen Applications management
Route::resource('applications', ApplicationController::class)
    ->only(['index', 'show', 'edit', 'update', 'destroy'])
    ->names('applications');
Route::post('applications/{application}/approve', [ApplicationController::class, 'approve'])
    ->name('applications.approve');
Route::post('applications/{application}/reject', [ApplicationController::class, 'reject'])
    ->name('applications.reject');
Route::post('applications/{application}/handover', [ApplicationController::class, 'handover'])
    ->name('applications.handover');

// Direct Certificates & Printing
Route::resource('certificates', CertificateController::class)
    ->only(['index', 'create', 'store', 'show', 'destroy'])
    ->names('certificates');
Route::get('certificates/{certificate}/print', [CertificateController::class, 'print'])
    ->name('certificates.print');
Route::post('certificates/{certificate}/handover', [CertificateController::class, 'handover'])
    ->name('certificates.handover');

// Reports & CSV Export
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
