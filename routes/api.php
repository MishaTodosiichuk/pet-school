<?php

use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PhotoGalleryController;
use Illuminate\Support\Facades\Route;

Route::get('menu', [MenuController::class, 'getMenu'])->name('get-menu');

Route::get('news', [NewsController::class, 'getNews'])->name('get-news');

Route::get('main-gallery', [PhotoGalleryController::class, 'getMainGallery'])->name('get-main-gallery');

Route::get('random-images', [ImageController::class, 'getRandomImage'])->name('get-random-images');

Route::middleware('auth:sanctum')->group(function () {

});
