<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['url', 'user_id', 'content', 'image', 'url_title', 'url_description', 'url_type'])]

class Post extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function postLikes(){
        return $this->hasMany(PostLike::class);
    }

}
