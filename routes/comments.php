<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Inertia\Inertia;
use Inertia\Response;

Route::get('/post', function(){
    return Inertia::render('Post');
});

Route::post('/post', [PostController::class,'create'])->name('post.create');