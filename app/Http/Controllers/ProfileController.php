<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit($me)
    {
        
         $id= Auth::id();
        // Récupération de l'utilisateur connecté
        $user = User::where('id', $me)->first();

       // (if (!$user) {
      //  $user = \App\Models\User::first();
      //  Auth::login($user);
      

        // Si aucune photo n'est définie, on assigne l'image par défaut
        if (empty($user->photo)) {
            $user->photo = Storage::url('codegirl.jpg');
        }

        // Récupération des posts de l'utilisateur
        $userPosts = $user->posts()->orderBy('created_at', 'desc')->get();

        // Récupération des posts likés classé par date
        $likedPosts = $user->likedPosts()->orderBy('post_likes.created_at', 'desc')->get();

        // envoie des données de l'utilisateur à la vue pour afficher
        return Inertia::render('Profile/Edit', [
            'user'       => $user,
            'userPosts'  => $userPosts,
            'likedPosts' => $likedPosts
        ]);
    }
    // cette fonction là c'est pour la modification 
    public function editForm(){
    $id= Auth::id();
        $user = User::where('id', $id)->first();
        //ça c'est pour pré-remplir le formulaire
        return Inertia::render('Profile/Update', [
            'auth' => [
                'user' => $user,
            ],
        ]);
    }
}
