<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SearchPostController;
use App\Http\Controllers\SearchCommentController;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/comments.php';
require __DIR__.'/profile.php';

Route::get('/', [SearchPostController::class, 'index'])->name('Post.index');

// Route::get('/test', function () {
//     return Inertia::render('test');
// });
