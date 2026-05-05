<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Transforme l'image en URL complète (fonctionne avec R2, S3, et stockage local)
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value && !str_starts_with($value, 'http')
                ? Storage::url($value)
                : $value,
        );
    }
}
