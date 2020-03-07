<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Event;
use Stripe\Stripe;
use Stripe\Charge;
use Auth;
use App\User;
use Carbon\Carbon;
use App\RecordsActivity;
class PurchaseTicket extends Model
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
    
    public function deliver(){
        $this->update(['delivered'=>true]);
    }
    
       public function scopeThisYear($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->firstOfYear());
    }
    
    public function scopeSpanningMonths($query,$months)
    {
        return $query->oldest()->whereMonth('created_at','>=','Carbon::now()->subMonth($months)');
    }
    
}
