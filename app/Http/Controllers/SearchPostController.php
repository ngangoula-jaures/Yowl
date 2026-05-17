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
            $query->where(function ($builder) use ($Search) {
                $builder->whereRaw('LOWER(content) LIKE ?', ['%'.$Search.'%'])
                    ->orWhereRaw('LOWER(url_title) LIKE ?', ['%'.$Search.'%'])
                    ->orWhereRaw('LOWER(url) LIKE ?', ['%'.$Search.'%']);
                
                // Gestion des alias d'URL (YouTube)
                if (str_contains($Search, 'youtube')) {
                    $builder->orWhereRaw('LOWER(url) LIKE ?', ['%youtu.be%']);
                } elseif (str_contains($Search, 'youtu.be')) {
                    $builder->orWhereRaw('LOWER(url) LIKE ?', ['%youtube.com%']);
                }
            });
        }

        $posts = $query->paginate(10)->withQueryString();
        
         return Inertia::render('Home', [
            'posts' => $posts
        ]);
    }
}