<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Inertia\Inertia;
class SearchCommentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $comments = Comment::where('content', 'LIKE', '%'.$search.'%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $comments = Comment::orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        }

        return Inertia::render('Comment', [
            'comments' => $comments
        ]);
    }
}
