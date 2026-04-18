<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController; 

Route::get('/mon-profil', [ProfileController::class, 'edit']);