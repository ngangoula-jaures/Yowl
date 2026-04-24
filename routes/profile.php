<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ProfileUpdateController;


//Route pour afficher le formulaire de modification
Route::get('/profile/edit', [ProfileController::class, 'editForm'])->name('profile.edit')->middleware('auth');
//Route pour enregistrer les modifications textuelles
Route::post('/profile/update', [ProfileUpdateController::class, 'update'])->name('profile.update')->middleware('auth');
    //Route pour enregistrer la nouvelle photo de profil
Route::post('/profile/update-photo', [ProfileUpdateController::class, 'updatePhoto'])->name('profile.photo')->middleware('auth');
//Route pour afficher la page principale du profil
Route::get('/profile/{me}', [ProfileController::class, 'edit'])->name('profile')->middleware('auth');
//Route pour supprimer un post depuis le profil
Route::post('/profile/post/{postId}/delete', [ProfileController::class, 'deletePost'])->name('profile.post.delete')->middleware('auth');