<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Notifications\ReplyHasAdded;
use App\RecordsActivity;

class Event extends Model implements Searchable
{
    use RecordsActivity;
    use SoftDeletes;
    
    protected $dates = ['deleted_at','strtdt','enddt'];

    protected $guarded=[];
    
    protected static $recordEvents = ['created','updated'];
    
    protected $appends = ['isFollowedTo'];
    
     public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function path()
    {
        return "/events/{$this->slug}";
    }
    
     public function topic(){
        return $this->belongsTo(Topic::class);
    }
    
     public static function boot()
    {
        parent::boot();
        static::deleting(function ($event) {
            $event->replies->each->delete();
        });
        static::created(function ($event) {
            $event->update(['slug'=>$event->name]);
            $event->topic()->increment('events_count');
        });
    }
    
       public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-".$this->id;
    }

        $this->attributes['slug'] = $slug;
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }
     public function purchaseTicket(){
        return $this->hasMany(PurchaseTicket::class);
    }
      public function followers(){
        return $this->hasMany(Follow::class);
    }
       
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);
        
        //Prepare notifications for all follower
        
        foreach($this->followers as $follower){
        if ($follower->user_id != $reply->user_id) {
            $follower->user->notify(new ReplyHasAdded($this,$reply));
        }
        }

        return $reply;
    }
    
    
      public function follow($userId = null)
    {
        $this->followers()->create([
            'user_id'=>$userId ?: auth()->id()
        ]);

        return $this;
    }
    
    public function unfollow($userId = null)
    {
        $this->followers()->where('user_id', $userId ?: auth()->id())->delete();
    }
    
     public function getIsFollowedToAttribute()
    {
        return  $this->followers()
            ->where('user_id', auth()->id())
            ->exists();
    }
       
      public function getSearchResult(): SearchResult
    {
       $url =  $this->slug;
         
       return new SearchResult($this, $this->name, $url);
    }
    
    public function getStartDateAttribute()
    {
        return Carbon::parse($this->strtdt)->format('j F, Y');
    }
    
    public function getEndDateAttribute()
    {
        return Carbon::parse($this->enddt)->format('j F, Y');
    }
    
     public function getEventStartAttribute()
    {
        return Carbon::parse($this->strtdt)->format('d-m-Y');
    }
    
    public function getEventEndAttribute()
    {
        return Carbon::parse($this->enddt)->format('d-m-Y');
    }
}
