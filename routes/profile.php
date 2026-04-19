<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ProfileUpdateController;
//Route pour afficher la page principale du profil
Route::get('/mon-profil', [ProfileController::class, 'edit']);
//Route pour afficher le formulaire de modification
Route::get('/profile/edit', [ProfileController::class, 'editForm']);
//Route pour enregistrer les modifications textuelles
Route::patch('/profile/update', [ProfileUpdateController::class, 'update'])
    ->middleware('auth');
    //Route pour enregistrer la nouvelle photo de profil
    Route::post('/profile/update-photo', [ProfileUpdateController::class, 'updatePhoto']);