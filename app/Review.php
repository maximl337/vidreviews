<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'reviewer_id',
        'token',
        'approved_at',
        'seen_at'
    ];

    protected $dates = [
        'approved_at',
        'seen_at',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }
}
