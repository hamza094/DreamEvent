<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Event extends Model implements Searchable
{
    protected $guarded=[];
    
    protected $appends = ['isFollowedTo'];
    
     public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function path()
    {
        return "/events/{$this->slug}";
    }
    
     public static function boot()
    {
        parent::boot();
        static::created(function ($event) {
            $event->update(['slug'=>$event->name]);
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
    public function topic(){
        return $this->belongsTo(Topic::class,'topic_id');
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
}
