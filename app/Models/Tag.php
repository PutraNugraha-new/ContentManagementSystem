<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Post (many-to-many)
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}
