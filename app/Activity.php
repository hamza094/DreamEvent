<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
     protected $guarded = [];
    
    protected $casts = ['changes' => 'array'];


    public function subject()
    {
        return $this->morphTo();
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

     public function topic(){
        return $this->belongsTo('App\Topic');
    }

    
}
