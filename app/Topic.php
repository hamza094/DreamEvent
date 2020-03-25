<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Topic extends Model
{
    
  protected $guarded = [];
    
     public function events(){
        return $this->hasMany(Event::class);
    }
    
      public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    public static function boot()
    {
        parent::boot();
        static::created(function ($topic) {
            $topic->update(['slug'=>$topic->name]);
        });
        static::deleting(function ($topic) {
            $topic->events->each->forceDelete();
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
}
