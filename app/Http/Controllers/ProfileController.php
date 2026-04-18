<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        

        // Récupération de l'utilisateur connecté
        $user = Auth::user();

       // (if (!$user) {
      //  $user = \App\Models\User::first();
      //  Auth::login($user);
       // }) vu que je ne voulais pas créer de page connexion c'est pourquoi j'avais fais pour utiliser le premier connecté qui était dans la base

        // Si aucune photo n'est définie, on assigne l'image par défaut
        if (empty($user->photo)) {
            $user->photo = '/images/icone.png';
        }

        // Récupération des posts de l'utilisateur
        $userPosts = $user->posts()->orderBy('created_at', 'desc')->get();

        // Récupération des posts likés
        $likedPosts = $user->likedPosts()->orderBy('post_likes.created_at', 'desc')->get();

        // Rendu de la vue avec Inertia et elles seront accessibles dans ton fichier Edit.vue via 'props'
        return Inertia::render('Profile/Edit', [
            'user'       => $user,
            'userPosts'  => $userPosts,
            'likedPosts' => $likedPosts
        ]);
    }
    }
