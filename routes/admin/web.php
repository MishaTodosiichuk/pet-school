<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');

    Route::post('menus/{menu}/publish', [MenuController::class, 'updatePublish'])->name('menus.publish');

    Route::resource('menus', MenuController::class)->except('show');
});
