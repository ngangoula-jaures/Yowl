<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchCommentController;
use Inertia\Inertia;
use Inertia\Response;

Route::get('/post', function(){
    return Inertia::render('Post');
})->name('post');

Route::post('/post', [PostController::class,'create'])->name('post.create');

Route::get('/post/{id}', [CommentController::class,'displayPostComments'])->name('post.comments');
Route::post('/post/{id}/like', [CommentController::class,'likePost'])->name('like.post');
Route::post('/post/{id}', [CommentController::class,'create'])->name('post.comments');
Route::post('/post/{id}/delete', [CommentController::class,'deleteComment'])->name('delete.comment');
Route::post('/post/{id}/delete', [CommentController::class,'deleteComment'])->name('delete.comment');
Route::get('/admin/dashboard', function () {
    return Inertia::render('DashboardKpi');
});