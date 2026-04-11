<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/comments.php';
require __DIR__.'/profile.php';

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Route::get('/test', function () {
//     return Inertia::render('test');
// });
