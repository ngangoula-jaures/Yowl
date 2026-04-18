<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Inertia\Inertia;
use Inertia\Response;

Route::get('/post', function(){
    return Inertia::render('Post');
})->name('post');

Route::post('/post', [PostController::class,'create'])->name('post.create');

Route::get('/comments/{id}', [CommentController::class,'displayPostComments'])->name('post.comments');
Route::post('/comments/{id}/like', [CommentController::class,'likePost'])->name('like.post');
Route::post('/comments/{id}', [CommentController::class,'create'])->name('post.comments');
Route::post('/comments/{id}/delete', [CommentController::class,'deleteComment'])->name('delete.comment');