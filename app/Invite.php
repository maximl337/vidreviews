<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'user_id',
        'invitee_email',
        'token',
        'message',
        'accepted_at',
        'submitted_at'
    ];

    protected $dates = [
        'accepted_at',
        'submitted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
