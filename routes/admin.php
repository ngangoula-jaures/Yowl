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