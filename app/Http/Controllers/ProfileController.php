<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();

     $couverture ='/images/couverture.jpg';
    if (!$user) {
        return Inertia::render('Profile/Edit', [
            'user' => [
                'pseudo' => 'Cybergirl',
                'bio' => 'Ceci est juste un essaie.',
                'photo' => '/images/codegirl.jpg',
                'couverture' => $couverture,
                
            ]
        ]);
    }

    return Inertia::render('Profile/Edit', [
        'user' => [
            'pseudo' => '',
            'bio' =>  '',
            'photo' =>  '',
            'coverture' => $user->$couverture,
            'post' => '',
                
        ]
    ]);
}
}