<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PhotoGalleryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');

    Route::post('menus/{menu}/publish', [MenuController::class, 'updatePublish'])->name('menus.publish');

    Route::post('news/{news}/publish', [NewsController::class, 'updatePublish'])->name('news.publish');

    Route::post('gallery/{gallery}/publish', [PhotoGalleryController::class, 'updatePublish'])->name('gallery.publish');

    Route::resource('menus', MenuController::class)->except('show');

    Route::resource('news', NewsController::class)->except('show');

    Route::resource('gallery', PhotoGalleryController::class)->except('show');

    Route::resource('contact', ContactController::class)->except(['show', 'create', 'store', 'destroy']);

    Route::resource('feedback', FeedbackController::class)->except(['create', 'store', 'edit', 'update']);

    Route::resource('page', PageController::class)->except('show');
});
