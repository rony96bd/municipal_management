<?php

use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\SearchController;
use Illuminate\Support\Facades\Route;


// require __DIR__ . '/web.php';

//==== front.php ======//
Route::get('/', [FrontController::class, 'index'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->middleware('throttle:30,1')->name('search');
Route::get('/officers', [FrontController::class, 'officers'])->name('officers');
Route::get('/notices', [FrontController::class, 'notices'])->name('notices');
Route::get('/officer/{page_url}', [FrontController::class, 'officerDetails'])->name('officer-details');
Route::get('/notice/{page_url}', [FrontController::class, 'noticeDetails'])->name('notice-details');
Route::get('/stuffs', [FrontController::class, 'stuffs'])->name('stuffs');
Route::get('/stuff/{page_url}', [FrontController::class, 'stuffDetails'])->name('stuff-details');
Route::get('/representatives', [FrontController::class, 'representatives'])->name('representatives');
Route::get('/representative/{page_url}', [FrontController::class, 'representativeDetails'])->name('representative-details');
Route::get('/page/{page_url}', [FrontController::class, 'singlepage'])->name('page-details');
Route::get('/news', [FrontController::class, 'news'])->name('news.list');
Route::get('/news/{page_url}', [FrontController::class, 'newsDetails'])->name('news-details');

// Dynamic posts (text + image, no social actions)
Route::get('/IUGIP-Projects', [FrontController::class, 'posts'])->name('posts.list');
Route::get('/IUGIP-Projects/{page_url}', [FrontController::class, 'postDetails'])->name('posts.details');

// Fallback asset routes for servers where Apache DocumentRoot does not directly serve newly pushed public assets
Route::get('/css/detail-card.css', function () {
    $path = public_path('css/detail-card.css');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200, ['Content-Type' => 'text/css; charset=UTF-8']);
    }
    abort(404);
});
Route::get('/js/detail-lightbox.js', function () {
    $path = public_path('js/detail-lightbox.js');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200, ['Content-Type' => 'application/javascript; charset=UTF-8']);
    }
    abort(404);
});

