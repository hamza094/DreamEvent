<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionReply extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply()
    {
        return $this->belongsTo(Reply::class, 'reply_id');
    }
}
