<?php

namespace App\Models;

use App\Events\CommentUpdated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    protected static function booted()
    {
        static::created(function ($comment) {
            Cache::forget('pending_comments_count');
        });

        static::updated(function ($comment) {
            Cache::forget('pending_comments_count');
        });

        static::deleted(function ($comment) {
            Cache::forget('pending_comments_count');
        });
    }
}
