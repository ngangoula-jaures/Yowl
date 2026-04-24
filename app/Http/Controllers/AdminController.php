<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function($query, $search) {
                $query->where('pseudo', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin', [
            'Users' => $users,
            'postsTotal' => Post::count(),
            'parentCommentsTotal' => Comment::whereNull('parent_id')->count(),
        ]);
    }

    public function showUsers(Request $request)
    {
        $users = User::query()
            ->when($request->search, function($query, $search) {
                $query->where('pseudo', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin', [
            'view' => 'users',
            'Users' => $users,
            'postsTotal' => Post::count(),
            'parentCommentsTotal' => Comment::whereNull('parent_id')->count(),
        ]);
    }

    public function showPosts(Request $request)
    {
        $posts = Post::with('user')
            ->when($request->search, function($query, $search) {
                $query->where('content', 'like', "%{$search}%")
                      ->orWhere('url', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin', [
            'view' => 'posts',
            'Posts' => $posts,
            'postsTotal' => Post::count(),
            'parentCommentsTotal' => Comment::whereNull('parent_id')->count(),
        ]);
    }

    public function showComments(Request $request)
{
    $comments = Comment::with('user')
        ->whereNull('parent_id')
        ->when($request->search, function($query, $search) {
            $query->where('content', '~*', $search);
        })
        ->latest()
        ->paginate(10);
    
    // Chargez manuellement les posts pour chaque commentaire
    $comments->getCollection()->transform(function ($comment) {
        $comment->post = Post::find($comment->post_id);
        return $comment;
    });

    return Inertia::render('Admin', [
        'view' => 'comments',
        'Comments' => $comments,
        'postsTotal' => Post::count(),
        'parentCommentsTotal' => Comment::whereNull('parent_id')->count(),
    ]);
}
    
    public function create(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
        $user = User::create([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'bio' => $request->bio,
            'role' => $request->role,
            'password' => $request->password, //Hash::make($request->password),
        ]);
        return redirect()->route('admin.index');
    }

public function deleteUser(Request $request)
{
    DB::transaction(function() use ($request) {
        $user = User::findOrFail($request->id);
        
        Comment::where('user_id', $user->id)->delete();
        
        $posts = Post::where('user_id', $user->id)->get();
        foreach($posts as $post) {
            Comment::where('post_id', $post->id)->delete();
            $post->delete();
        }
        
        $user->delete();
    });

    return redirect()->back();
}

public function deletePost(Request $request)
{
    DB::transaction(function() use ($request) {
        $post = Post::findOrFail($request->id);
        Comment::where('post_id', $post->id)->delete();
        $post->delete();
    });

    return redirect()->back();
}

public function deleteCommentParent(Request $request)
{
    DB::transaction(function() use ($request) {
        $comment = Comment::findOrFail($request->id);
        Comment::where('parent_id', $comment->id)->delete();
        $comment->delete();
    });

    return redirect()->back();
}
}