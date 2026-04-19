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
    //c'était pour le test vu que je ne voulais pas faire de formulaire d'inscription
      // if (!$user) {
       // $user = \App\Models\User::first();
      //  Auth::login($user);
      

        // Récupération des posts de l'utilisateur du plus récent au plus ancien
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
    public function editForm()
{
    //ça c'est pour pré-remplir le formulaire
    return Inertia::render('Profile/Update', [
        'auth' => [
            'user' => auth()->user(),
        ],
    ]);
}
    }
