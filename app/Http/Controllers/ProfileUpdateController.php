<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateController extends Controller
{
    public function update(Request $request)
    {
        //vérification des donées de l'utilisteur 
        $validated = $request->validate([
            'pseudo' => 'string|max:255',
            'email' => 'email|max:255',
            'bio' => 'nullable|string|max:1000',
            
        ]);

        //  on cherche l'utilisteur dans la bdd et on modifie ces données
        $request->user()->update($validated);

        // retour sur sa page de profil 
        return redirect('/mon-profil');
    }
    public function updatePhoto(Request $request) 
{   //c'est pour voir si l'image est autorisée
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // je stocke dans 'public/images' (ce qui correspond à storage/app/public/images)
    $path = $request->file('photo')->store('images', 'public');

    //  Récupérer uniquement le nom du fichier (pour le stocker en base)
    $fileName = basename($path);

    // mettre à jour l'utilisateur
    $user = $request->user();
    $user->photo = $fileName;
    $user->save();

    return redirect('/mon-profil');
}
}
