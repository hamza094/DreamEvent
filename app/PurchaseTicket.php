<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Event;
use Stripe\Stripe;
use Stripe\Charge;
use Auth;
use App\User;

class PurchaseTicket extends Model
{
    protected $guarded=[];
    
    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
