<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ReplyAddedToDiscussion;
use App\RecordsActivity;
class Reply extends Model
{
    use RecordsActivity;

    protected $guarded=[];
    
    protected static $recordEvents = ['created','updated'];

    
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
         
    if($this->user->id != $discussionreply->user->id){
        
    //Prepare notifications when new discussion reply added
      $this->user->notify(new ReplyAddedToDiscussion($this,$discussionreply));
    }

        return $discussionreply;
    }
    
        public static function boot()
    {
        parent::boot();
        static::deleting(function ($reply) {
            $reply->discussionreplies->each->delete();
        });
    }
    
      public function path()
    {
         $perPage = config('dream.pagination.perPage');
         $replyPosition = $this->event->replies()->pluck('id')->search($this->id) + 1;
         $page = ceil($replyPosition / $perPage);
         return $this->event->path()."?page={$page}#reply-{$this->id}";
    }
}
