<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['comment_id', 'user_id'])]

class CommentLike extends Model
{
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
