<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return file_get_contents(public_path('index.html'));
});

Route::get('/{page}', function ($page) {
    $file = public_path($page);

    if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'html') {
        return file_get_contents($file);
    }

    abort(404);
})->where('page', '.*\\.html');
