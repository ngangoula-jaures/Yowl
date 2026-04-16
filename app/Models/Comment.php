<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['user_id', 'post_id', 'content', 'parent_id'])]

class Comment extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function responses(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
