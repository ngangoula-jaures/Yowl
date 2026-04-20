<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardKpi;
use App\Http\Controllers\SearchCommentController;
use App\Http\Controllers\DashboardKpiController;
use Inertia\Inertia;
use Inertia\Response;

Route::get('/post', function(){
    return Inertia::render('Post');
})->name('post')->middleware('auth');

Route::post('/post', [PostController::class,'create'])->name('post.create')->middleware('auth');

Route::controller(CommentController::class)->middleware('auth')->group(function(){
Route::get('/post/{id}', [CommentController::class,'displayPostComments'])->name('post.comments');
Route::post('/post/{id}/like', [CommentController::class,'likePost'])->name('like.post');
Route::post('/post/{id}', [CommentController::class,'create'])->name('post.comments');
Route::post('/post/{id}/delete', [CommentController::class,'deleteComment'])->name('delete.comment');
Route::post('/post/{id}/delete', [CommentController::class,'deleteComment'])->name('delete.comment');
});

Route::get('/admin/dashboard', [DashboardKpiController::class,'displayDashboardKpi'])->name('dashboard.kpi')->middleware(['auth',\App\Http\Middleware\IsAdmin::class]);
