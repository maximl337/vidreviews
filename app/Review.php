<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'reviewer_id',
        'video_url',
        'thumbnail',
        'token',
        'approved_at',
        'seen_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }
}
