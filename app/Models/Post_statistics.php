<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_statistics extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function updateTrendingScore()
    {
        $weeklyViews = $this->post->views()
            ->where('viewed_at', '>=', now()->subWeek())
            ->count();

        $this->trending_score = $this->calculateScore($weeklyViews);
        $this->save();
    }
}
