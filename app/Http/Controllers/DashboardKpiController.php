<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\PostLike;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardKpiController extends Controller
{
    public function displayDashboardKpi(){
        $days= [];
        $users= [];
        $posts= [];
        $comments = [];
        $domains = [];
        $totalPosts= [];
        $totalComments=[];
        $ratio = [];
        
        Carbon::setLocale('fr');

        for($i=6; $i>=0; $i--){
            $date = Carbon::now()->subDays($i);
            $dateString = $date->toDateString();
            $days[] = $date->translatedFormat('l');
            $users[] = User::whereDate('created_at', $dateString)->count();
            $comments[] = Comment::whereDate('created_at', $dateString)->count();
            $posts[] = Post::whereDate('created_at', $dateString)->count();

        }

        $chartData = [
            'days'=>$days, 
            'usersNumber'=>$users, 
            'commentsNumber'=>$comments, 
            'postsNumber'=>$posts
        ];

        $topDomains= DB::table('posts')->select(DB::raw("
        split_part(replace(replace(replace(url,'https://', ''),'http://', ''), 'www.', ''), '/', 1) as domaine,
        count(DISTINCT posts.id) as totalPosts, count(DISTINCT comments.id) as totalComments, 
        (count(DISTINCT comments.id)::float / NullIF(count(DISTINCT posts.id), 0)) as ratio
        "))->leftJoin('comments', 'comments.post_id', '=', 'posts.id')
        ->groupBy('domaine')
        ->orderBy('ratio', 'desc')
        ->limit(5)
        ->get();

        foreach($topDomains as $data){
            $domains[]= $data->domaine;
            $totalPosts[] = $data->totalposts;
            $totalComments[] = $data->totalcomments;
            $ratio[] = $data->ratio;
        }

        $chartDognutDatas= [
          'domains'=>$domains,
          'totalPosts'=>$totalPosts,
          'totalComments'=>$totalComments,
          'ratio'=>$ratio
        ];

        $userCount = User::count();
        $postsCount = Post::count();
        $commentsCount = Comment::count();
        $likesCount = (PostLike::count() + CommentLike::count());

        $count=[
            'userCount'=>$userCount,
            'postCount'=> $postsCount,
            'commentCount'=> $commentsCount,
            'likeCount'=> $likesCount
        ];
        session()->flash('success', "Toutes l'évolution de Yowl ici");
        return Inertia::render('DashboardKpi', compact('chartData', 'chartDognutDatas', 'count'));
    }
}
