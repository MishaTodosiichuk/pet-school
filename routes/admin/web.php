<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');

    Route::post('menus/{menu}/publish', [MenuController::class, 'updatePublish'])->name('menus.publish');

    Route::post('news/{news}/publish', [NewsController::class, 'updatePublish'])->name('news.publish');

    Route::resource('menus', MenuController::class)->except('show');

    Route::resource('news', NewsController::class)->except('show');
});
