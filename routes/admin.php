<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchPostController;
use App\Http\Controllers\SearchCommentController;


Route::get('/admin', function () {
    return Inertia::render('Admin');
});

Route::get('/home/{s?}', [SearchPostController::class, 'index'])->name('Post.index');
Route::get('/comments/{s?}', [SearchCommentController::class, 'index'])->name('Comment.index');

Route::controller(AdminController::class)->group(function () {
    Route::post('/post', 'create')->name('Admin.create');
    Route::put('/post/{id}', 'update')->name('Admin.update');
    Route::delete('/post/{id}', 'delete')->name('Admin.delete');
});