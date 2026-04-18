<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentLike;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function displayPostComments($id){
        $post= Post::findOrFail($id);
        $user= $post->user;
        $postLikes= PostLike::where('post_id', $id)->count();
        $numberComments = Comment::where('post_id', $id)->count();
        $comments= Comment::with('user', 'responses.user')->where('post_id', $id)->whereNull('parent_id')->get();
        $currentUserId= 1;//Auth::id()
        $currentUser= User::find($currentUserId);

        return Inertia::render('Comment', compact('post','postLikes', 'user', 'numberComments', 'currentUser', 'comments'));
    }

    public function create(Request $request, $id){
        $post= Post::findOrFail($id);
        $user= $post->user;
        $postLikes= PostLike::where('post_id', $id)->count();
        $numberComments = Comment::where('post_id', $id)->count();
        
        $currentUserId= 1;//Auth::id()
        $currentUser= User::find($currentUserId);
        $content = $request->comment;
        if($request->response){
            $response = $request->response;
            $parent_Id = $request->forResponseId;
            Comment::create([
            'user_id'=>$currentUserId,
            'post_id'=> $id,
            'content'=>$response,
            'parent_id'=> $parent_Id
        ]);
        }else{
            Comment::create([
            'user_id'=>$currentUserId,
            'post_id'=> $id,
            'content'=>$content,
            ]);
        }
        
        $comments= Comment::with('user', 'responses.user')->where('post_id', $id)->whereNull('parent_id')->get();
        session()->flash('success','commentaire ajouté');
        return Inertia::render('Comment', compact('post','postLikes', 'user', 'numberComments', 'currentUser', 'comments'));
    }

    public function likePost(Request $request, $id){

        $post_id= $request->postId;
        $user_id= $request->userId;
        $like= PostLike::where('post_id', $post_id)->where('user_id', $user_id)->select('id')->first();
        if(!$like || $like === null){
            PostLike::create([
                'post_id'=> $post_id,
                'user_id'=> $user_id
            ]);
        }else{
            return redirect()->route('post.comments', ['id'=>$post_id])->with('echec','post déjà liké');
        }

        return redirect()->route('post.comments', ['id'=>$post_id])->with('success','post liké');

    }

    public function deleteComment(Request $request, $id){
        $commentId = $request->commentId;
        $comment = Comment::where('id', $commentId)->firstOrFail();
        $comment->delete();

        return redirect()->route('post.comments', ['id'=>$id])->with('success','commentaire supprimé');
    }
}
