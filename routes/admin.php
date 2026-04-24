<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchPostController;
use App\Http\Controllers\SearchCommentController;


// Route::get('/admin', function () {
    // return Inertia::render('Admin');
// });


Route::get('/comments/{s?}', [SearchCommentController::class, 'index'])->name('Comment.index')->middleware('auth');

Route::controller(AdminController::class)->middleware(['auth',\App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::delete('/admin/post/{id}', [AdminController::class, 'deletePost'])->name('admin.deletePost');
    Route::delete('/admin/comment/{id}', [AdminController::class, 'deleteCommentParent'])->name('admin.deleteComment');
    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.showUsers');
    Route::get('/admin/posts', [AdminController::class, 'showPosts'])->name('admin.showPosts');
    Route::get('/admin/comments', [AdminController::class, 'showComments'])->name('admin.showComments');
});
Route::get('/home/{s?}', [SearchPostController::class, 'index'])->name('home.index');