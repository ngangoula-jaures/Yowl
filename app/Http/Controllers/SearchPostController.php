<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class SearchPostController extends Controller
{
    //affichage de tous les posts
    public function index(Request $request){

        $posts = Post::query();
        
        if ($search = $request->search){
            $posts->where('title', 'LIKE', '%'.$search.'%')
            ->orwhere('oembedUrl', 'LIKE', '%'.$search.'%');
        }
        
        return Inertia::render('Home', [
            'Posts' => $posts->latest()->paginate(10),
        ]);
    }
}
