<?php

namespace App\Models;
// use App\Models\PostLike;
// use App\Models\Comment;
// use App\Models\CommentLike;
// use App\Models\TmpUser;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['pseudo', 'email', 'bio', 'role', 'password', 'photo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likedPosts(){
        return $this->belongsToMany(Post::class, 'post_likes');
    }

    public function likedComments(){
        return $this->belongsToMany(Comment::class, 'comment_likes');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Transforme la photo en URL complète (fonctionne avec R2, S3, et stockage local)
     */
    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value && !str_starts_with($value, 'http')
                ? Storage::url($value)
                : $value,
        );
    }
}
