<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/admin', function () {
    return Inertia::render('Admin');
});

Route::get('/home', function () {
    return Inertia::render('Home');
});

Route::post('/post', [AdminController::class,'create'])->name('Admin.create');
Route::put('/post', [AdminController::class,'update'])->name('Admin.update');
Route::delete('/post', [AdminController::class,'delete'])->name('Admin.delete');