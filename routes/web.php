<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/admin/web.php';

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
