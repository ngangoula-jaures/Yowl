<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileUpdateController extends Controller
{
    public function update(Request $request)
    {
        //vérification des donées de l'utilisteur 
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo'=>'image|mimes:jpg,png,jpeg,webp|max:2000'
            
        ]);
            $id= Auth::id();
            if($request->photo !== null || $request->photo){
                
                $image = $request->file('photo')->store('images', 'public');
                User::where('email', $request->email)->update([
                    'email'=>$request->email,
                    'pseudo'=>$request->pseudo,
                    'bio'=>$request->bio,
                    'photo'=>$image
                ]);
                return redirect()->route('profile', ['me'=>$id])->with('success', 'vous avez changé vos infos');
            }
        //  on cherche l'utilisteur dans la bdd et on modifie ces données
        User::where('email', $request->email)->update([
            'email'=>$request->email,
            'pseudo'=>$request->pseudo,
            'bio'=>$request->bio
        ]);

        // retour sur sa page de profil 
        return redirect()->route('profile', ['me'=>$id])->with('success', 'vous avez changé vos infos');;
    }
    public function updatePhoto(Request $request) 
{   //c'est pour voir si l'image est autorisée
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $id= Auth::id();
    $image = $request->file('photo')->store('images', 'public');
    User::where('id', $id)->update([
        'photo'=>$image
    ]);

    // je stocke dans 'public/images' (ce qui correspond à storage/app/public/images)
    // $path = $request->file('photo')->store('images', 'public');

    // //  Récupérer uniquement le nom du fichier (pour le stocker en base)
    // $fileName = basename($path);

    // // mettre à jour l'utilisateur
    // $user = $request->user();
    // $user->photo = $fileName;
    // $user->save();



    return redirect()->route('profile', ['me'=>$id])->with('success', 'vous avez changé votre avatar');
}
}
