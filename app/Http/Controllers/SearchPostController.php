<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class SearchPostController extends Controller
{
    public function index(Request $request, $s = null)
    {
        $search = $request->input('search', $s);
        $Search = mb_strtolower($search ?? '');

        $query = Post::query()
            ->withCount(['postLikes', 'comments'])
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($builder) use ($search) {
                $builder->whereRaw('LOWER(content) LIKE ?', ['%'.$search.'%'])
                    ->orWhereRaw('LOWER(url_title) LIKE ?', ['%'.$search.'%']);
            });
        }

        $posts = $query->paginate(10)->withQueryString();
        
         return Inertia::render('Home', [
            'posts' => $posts
        ]);
    }
}