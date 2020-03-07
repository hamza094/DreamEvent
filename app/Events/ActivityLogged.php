<?php

namespace App\Events;

use App\Activity;
use App\Http\Resources\Activity as ActivityResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityLogged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $activity;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
      public function __construct(Activity $activity)
    {
        $this->activity = $activity;
          
    }
    
     public function broadcastOn()
    {
        return new Channel('activity');
    }

    public function broadcastWith()
    {
         return (new ActivityResource($this->activity))->resolve();
        
  
    }


}
