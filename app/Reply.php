<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded=[];
    
    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
     public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
    
     public function discussionreplies(){
        return $this->hasMany(DiscussionReply::class);
    }
    
     public function addDiscussionReply($discussionreply)
    {
        $discussionreply = $this->discussionreplies()->create($discussionreply);

        return $discussionreply;
    }
}
