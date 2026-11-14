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

Route::get('/js/client-image-optimizer.js', function () {
    $path = public_path('js/client-image-optimizer.js');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200, ['Content-Type' => 'application/javascript; charset=UTF-8']);
    }
    abort(404);
});

Route::get('/uploads/{path}', function (string $path) {
    $cleanPath = trim(str_replace(['..', '\\'], ['', '/'], $path), '/');
    if ($cleanPath === '') {
        abort(404);
    }
    $subPath = 'uploads/' . $cleanPath;

    $publicHtmlFile = \App\Services\ImageOptimizer::publicUploadRoot($subPath);
    if (file_exists($publicHtmlFile) && is_file($publicHtmlFile)) {
        return response()->file($publicHtmlFile);
    }

    $localPublicFile = public_path($subPath);
    if (file_exists($localPublicFile) && is_file($localPublicFile)) {
        // Self-heal: sync copy to public_html so Apache serves directly next time
        $dir = dirname($publicHtmlFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @copy($localPublicFile, $publicHtmlFile);
        return response()->file($localPublicFile);
    }

    abort(404);
})->where('path', '.*');

Route::get('/pages/{path}', function (string $path) {
    $cleanPath = trim(str_replace(['..', '\\'], ['', '/'], $path), '/');
    if ($cleanPath === '') {
        abort(404);
    }
    $subPath = 'pages/' . $cleanPath;

    $publicHtmlFile = \App\Services\ImageOptimizer::publicUploadRoot($subPath);
    if (file_exists($publicHtmlFile) && is_file($publicHtmlFile)) {
        return response()->file($publicHtmlFile);
    }

    $localPublicFile = public_path($subPath);
    if (file_exists($localPublicFile) && is_file($localPublicFile)) {
        $dir = dirname($publicHtmlFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @copy($localPublicFile, $publicHtmlFile);
        return response()->file($localPublicFile);
    }

    abort(404);
})->where('path', '.*');

