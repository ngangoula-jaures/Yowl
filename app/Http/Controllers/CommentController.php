<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private function getComments($postId, $currentUserId){
        return Comment::with('user', 'likes', 'responses.user', 'responses.likes')
            ->withCount('likes')
            ->with(['responses' => function($query){
                $query->withCount('likes');
            }])
            ->where('post_id', $postId)
            ->whereNull('parent_id')
            ->get()
            ->map(function ($comment) use ($currentUserId) {
                $comment->liked_by_user = $comment->likes->contains('user_id', $currentUserId);
                $comment->responses = $comment->responses->map(function ($response) use ($currentUserId) {
                    $response->liked_by_user = $response->likes->contains('user_id', $currentUserId);
                    return $response;
                });
                return $comment;
            });
    }

    public function displayPostComments($id){
        $post= Post::findOrFail($id);
        $user= $post->user;
        $postLikes= PostLike::where('post_id', $id)->count();
        $numberComments = Comment::where('post_id', $id)->count();
        $currentUserId= Auth::id();
        $currentUser= User::find($currentUserId);
        $comments = $this->getComments($id, $currentUserId);

        return Inertia::render('Comments', compact('post','postLikes', 'user', 'numberComments', 'currentUser', 'comments'));
    }

    public function create(Request $request, $id){
        $post= Post::findOrFail($id);
        $user= $post->user;
        $postLikes= PostLike::where('post_id', $id)->count();
        $numberComments = Comment::where('post_id', $id)->count();
        
        $currentUserId= Auth::id();
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
        
        $comments = $this->getComments($id, $currentUserId);
        session()->flash('success','commentaire ajouté');
        return Inertia::render('Comments', compact('post','postLikes', 'user', 'numberComments', 'currentUser', 'comments'));
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
            return redirect()->route('post.comments', ['id'=>$post_id])->with('success','post liké');
        }else{
            $like->delete();
            return redirect()->route('post.comments', ['id'=>$post_id])->with('echec','like supprimé');
        }

    }

    public function likeComment(Request $request, $id){
        $comment_id = $request->commentId;
        $user_id = Auth::id();

        $existingLike = CommentLike::where('comment_id', $comment_id)
            ->where('user_id', $user_id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return redirect()->route('post.comments', ['id' => $id])->with('echec', 'like supprimé');
        } else {
            CommentLike::create([
                'comment_id' => $comment_id,
                'user_id'    => $user_id,
            ]);
        }

        return redirect()->route('post.comments', ['id' => $id])->with('success', 'commentaire liké');
    }

    public function deleteComment(Request $request, $id){
        $commentId = $request->commentId;
        $comment = Comment::where('id', $commentId)->firstOrFail();
        $comment->delete();

        return redirect()->route('post.comments', ['id'=>$id])->with('success','commentaire supprimé');
    }
}
