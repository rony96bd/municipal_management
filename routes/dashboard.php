<?php

use App\Http\Controllers\dash\AboutController;
use App\Http\Controllers\dash\BannerSlidderController;
use App\Http\Controllers\dash\cachecontroller;
use App\Http\Controllers\dash\dashboardController;
use App\Http\Controllers\dash\GalleryController;
use App\Http\Controllers\dash\MenuController;
use App\Http\Controllers\dash\NewsController;
use App\Http\Controllers\dash\NoticeController;
use App\Http\Controllers\dash\OfficoalsController;
use App\Http\Controllers\dash\PageController;
use App\Http\Controllers\dash\RepresntativesController;
use App\Http\Controllers\dash\ServiceController;
use App\Http\Controllers\dash\SidebarController;
use App\Http\Controllers\dash\SiteSettings;
use App\Http\Controllers\dash\SiteSettingsController;
use App\Http\Controllers\dash\StuffsController;
use App\Http\Controllers\dash\UserListController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//==== dashboard.php ======//

require __DIR__ . '/auth.php';
Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {
        // Cache Clear
        Route::post('/clear-cache', [cachecontroller::class, 'clearCache'])->name('clear.cache');
        // Pages Routes
        Route::get('/pages', [PageController::class, 'pagelist'])->name('pages');
        Route::get('/create-page', [PageController::class, 'createpage'])->name('create-page');
        Route::post('/create-page', [PageController::class, 'store'])->name('store-page');
        Route::get('/edit-page/{id}', [PageController::class, 'edit'])->name('edit-page');
        Route::post('/edit-page/{id}', [PageController::class, 'update'])->name('update-page');
        Route::delete('/delete-page/{id}', [PageController::class, 'destroy'])->name('delete-page');
        Route::post('/update-page-order', [PageController::class, 'updatePageOrder'])->name('update-page-order');
        // officials
        Route::get('/officials', [OfficoalsController::class, 'officialslist'])->name('officialslist');
        Route::get('/create-official', [OfficoalsController::class, 'createofficial'])->name('create-official');
        Route::post('/create-official', [OfficoalsController::class, 'store'])->name('store-official');
        Route::get('/edit-official/{id}', [OfficoalsController::class, 'edit'])->name('edit-official');
        Route::post('/edit-official/{id}', [OfficoalsController::class, 'update'])->name('update-official');
        Route::delete('/delete-official/{id}', [OfficoalsController::class, 'destroy'])->name('delete-official');
        Route::post('/update-order', [OfficoalsController::class, 'updateOrder'])->name('update-order');

        // Stuffs
        Route::get('/stuffs', [StuffsController::class, 'stuffslist'])->name('stuffslist');
        Route::get('/create-stuff', [StuffsController::class, 'createstuff'])->name('create-stuff');
        Route::post('/create-stuff', [StuffsController::class, 'store'])->name('store-stuff');
        Route::get('/edit-stuff/{id}', [StuffsController::class, 'edit'])->name('edit-stuff');
        Route::post('/edit-stuff/{id}', [StuffsController::class, 'update'])->name('update-stuff');
        Route::delete('/delete-stuff/{id}', [StuffsController::class, 'destroy'])->name('delete-stuff');
        Route::post('/update-stuffs-order', [StuffsController::class, 'updateOrder'])->name('update-stuffs-order');
        // Representatives
        Route::get('/representatives', [RepresntativesController::class, 'representativesslist'])->name('representativeslist');
        Route::get('/create-representative', [RepresntativesController::class, 'createsrepresentative'])->name('create-representative');
        Route::post('/create-representative', [RepresntativesController::class, 'store'])->name('store-representative');
        Route::get('/edit-representative/{id}', [RepresntativesController::class, 'edit'])->name('edit-representative');
        Route::post('/edit-representative/{id}', [RepresntativesController::class, 'update'])->name('update-representative');
        Route::delete('/delete-representative/{id}', [RepresntativesController::class, 'destroy'])->name('delete-representative');
        Route::post('/update-re-order', [RepresntativesController::class, 'updateOrder'])->name('update-rep-order');
        // Services
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/create-service', [ServiceController::class, 'createservice'])->name('create-service');
        Route::post('/create-service', [ServiceController::class, 'store'])->name('store-service');
        Route::get('/edit-service/{service_id}', [ServiceController::class, 'edit'])->name('edit-service');
        Route::post('/edit-service/{service_id}', [ServiceController::class, 'update'])->name('update-service');
        Route::delete('/delete-service/{id}', [ServiceController::class, 'destroy'])->name('delete-service');
        Route::get('/service/configure/{page_url}', [ServiceController::class, 'configure'])->name('service-configure');
        Route::post('/service/configure/{page_url}', [ServiceController::class, 'storesingleservice'])->name('configure-single-service-store');
        Route::get('/service/item/edit/{id}', [ServiceController::class, 'editsingleserviceitem'])->name('edit-single-service-item');
        Route::put('/service/item/edit/{id}', [ServiceController::class, 'singleserviceupdate'])->name('single-service-update');
        Route::delete('service/item/delete/{id}', [ServiceController::class, 'deletesingleservice'])->name('delete-single-service');
        Route::post('/update-service-order', [ServiceController::class, 'updateServiceOrder'])->name('update-service-order');
        Route::post('/update-sin-service-order', [ServiceController::class, 'updateSingleServiceOrder'])->name('update-sin-service-order');

        // Site Settings
        Route::get('/site-setting', [SiteSettingsController::class, 'index'])->name('site-setting');
        Route::post('/site-setting', [SiteSettingsController::class, 'storeOrUpdate'])->name('setting-update');
        Route::delete('/site-settings', [SiteSettingsController::class, 'reset'])->name('site-settings.reset');
        // Notice
        Route::get('/notice', [NoticeController::class, 'index'])->name('notice');
        Route::get('add-notice', [NoticeController::class, 'createnotice'])->name('create-notice');
        Route::post('notice/add', [NoticeController::class, 'store'])->name('store-notice');
        Route::get('edit-notice/{id}', [NoticeController::class, 'edit'])->name('edit-notice');
        Route::delete('/delete-attestment/{id}', [NoticeController::class, 'deleteAttestment'])->name('delete-attestment');
        Route::put('/notice-update/{id}', [NoticeController::class, 'update'])->name('notice-update');
        Route::delete('/notice/delete/{id}', [NoticeController::class, 'delete'])->name('notice-delete');
        Route::post('/update-notice-order', [NoticeController::class, 'updateNoticeOrder'])->name('update-notice-order');
        // News
        Route::get('news', [NewsController::class, 'index'])->name('news');
        Route::get('create-news', [NewsController::class, 'createnews'])->name('create-news');
        Route::get('edit-news/{id}', [NewsController::class, 'edit'])->name('edit-news');
        Route::put('edit-news/{id}', [NewsController::class, 'update'])->name('news-update');
        Route::post('create-news', [NewsController::class, 'store'])->name('store-news');
        Route::post('/update-news-order', [NewsController::class, 'updateNewsOrder'])->name('update-news-order');
        // Users
        Route::get('user-list', [UserListController::class, 'UsersList'])->name('users-list');
        // About
        Route::get('about', [AboutController::class, 'index'])->name('about');
        Route::post('about', [AboutController::class, 'store'])->name('about.store');
        // Gallery
        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::get('create-gallery', [GalleryController::class, 'create'])->name('create-gallery');
        Route::post('create-gallery', [GalleryController::class, 'store'])->name('store-gallery');

        // Banner Slidder
        Route::get('banner-slidder', [BannerSlidderController::class, 'index'])->name('banner-slidder');
        Route::get('create-banner-slidder', [BannerSlidderController::class, 'create'])->name('create-banner-slidder');
        Route::post('create-banner-slidder', [BannerSlidderController::class, 'store'])->name('store-banner-slidder');

        // Sidebar
        Route::get('sidebar', [SidebarController::class, 'index'])->name('sidebar');
        Route::post('create-sidebar', [SidebarController::class, 'store'])->name('store-sidebar');
        Route::post('update-sidebar-order', [SidebarController::class, 'updatesidebarOrder'])->name('update-sidebar-order');
        Route::delete('delete-sidebar/{id}', [SidebarController::class, 'destroy'])->name('delete-sidebar');

        //Top Menus
        Route::get('menus', [MenuController::class, 'index'])->name('menus');
        Route::post('create-menu', [MenuController::class, 'storetopmenu'])->name('store-top-menu');
        Route::delete('delete/top-menu/{id}', [MenuController::class, 'deletetopmenu'])->name('delete-top-menu');
        Route::post('update-top-menu-order', [MenuController::class, 'updatemainmenuorder'])->name('update-main-menu-order');
        // Simple Sub Menus
        Route::get('add-single-submenu/{id}', [MenuController::class, 'addsimplesubmenu'])->name('add-single-submenu');
        Route::post('add-simple-submenu', [MenuController::class, 'storesimplesubmenu'])->name('add-simple-submenu');
        Route::delete('delete-simple-submenu/{id}', [MenuController::class, 'deletesinglesubmenu'])->name('delete-singles-ubmenu');
        Route::post('update-simple-submenu-order', [MenuController::class, 'updatesubmenuorder'])->name('update-submenu-order');
        // Group Menu
        Route::get('/create-group-menu/{id}', [MenuController::class, 'groupmenupage'])->name('group-menu-page');
        Route::post('/create-group-menu', [MenuController::class, 'storegroupmenu'])->name('store-group-menu');
        Route::delete('/delete-group-menu/{id}', [MenuController::class, 'deletemenugroup'])->name('delete-menu-group');
        Route::post('/update-group-menu-order', [MenuController::class, 'updategroupmenuorder'])->name('update-group-menu-order');
        // Single Submen For Group
        Route::get('/single-group-menu/{id}', [MenuController::class, 'singlegroupmenu'])->name('single-group-menu');
        Route::post('/single-group-menu', [MenuController::class, 'storesinglegroupmenu'])->name('store-single-group-menu');
        Route::delete('/delete-single-group-menu/{id}', [MenuController::class, 'deletegroupsubmenu'])->name('delete-group-submenu');
        Route::post('/update-group-sub-menu-order', [MenuController::class, 'updategroupsubmenuorder'])->name('update-group-submenu-order');
    });
});
