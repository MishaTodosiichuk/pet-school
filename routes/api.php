<?php

use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PhotoGalleryController;
use Illuminate\Support\Facades\Route;

Route::get('menu', [MenuController::class, 'getMenu'])->name('get-menu');

Route::get('news', [NewsController::class, 'getNews'])->name('get-news');
Route::get('news-all-data', [NewsController::class, 'index'])->name('get.index.news');
Route::get('news-show-single/{slug}', [NewsController::class, 'show'])->name('get.show.news');

Route::post('news/{news:slug}/views', [NewsController::class, 'incrementViews']);

Route::get('main-gallery', [PhotoGalleryController::class, 'getMainGallery'])->name('get-main-gallery');

Route::get('page-gallery', [PhotoGalleryController::class, 'getPageGallery'])->name('get-page-gallery');

Route::get('random-images', [ImageController::class, 'getRandomImage'])->name('get-random-images');

Route::middleware('auth:sanctum')->group(function () {

});
