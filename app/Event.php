<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Event extends Model implements Searchable
{
    protected $guarded=[];
    
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
        $this->belongsTo('App\User');
    }
    public function topic(){
        $this->belongsTo('App\Topics');
    }
    
      public function getSearchResult(): SearchResult
    {
       $url =  $this->slug;
         
       return new SearchResult($this, $this->name, $url);
    }
}
