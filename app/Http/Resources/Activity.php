<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Activity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'description'=>call_user_func_array([$this, $this->name], [$this]),
            'link'=>call_user_func_array([$this, $this->link], [$this]),
            'lapse' => $this->created_at->diffForHumans(),
            'user'=>$this->user,
            'title'=>call_user_func_array([$this, $this->title], [$this]),
            ];
          
    }
    
    //Ticket Activities
    protected function created_event()
	{
		return  "Created an event";
	}
    
    protected function created_event_link()
	{
		return  '/events/'.$this->subject->slug;
	}
    
    protected function created_event_title(){
         return $this->subject->name;
    }
    
    protected function updated_event()
	{
		return  "Updated event";
	}
    
    protected function updated_event_link()
	{
		return  '/events/'.$this->subject->slug;
	}
    
    protected function updated_event_title(){
         return $this->subject->name." ".key($this->changes['after']);
    }
    
    //Ticket Activities
    protected function created_purchaseticket()
	{
		return "Purchased ".$this->subject->qty." ticket with total amount of $".$this->subject->total." of an event";
	}
    
    protected function created_purchaseticket_link()
	{
		return  '/event/'.$this->subject->event->slug;
	}
    
    protected function created_purchaseticket_title(){
         return $this->subject->event->name;
    }
    
    protected function updated_purchaseticket()
	{
		return  "Deliver purchased ticket to user";
	}
    
    protected function updated_purchaseticket_link()
	{
		return  '/manage-tickets/';
	}
    
    protected function updated_purchaseticket_title(){
         return '#'.$this->subject->receipt;
    }
    
    //Discussion Activities
    protected function created_reply()
	{
		return 'Created a new discussion to event';
	}
    
    protected function created_reply_link()
	{
		return  $this->subject->path();
	}
    
    protected function created_reply_title(){
         return $this->subject->event->name;
    }
    
    protected function updated_reply()
	{
		return  "Updated event discussion";
	}
    
    protected function updated_reply_link()
	{
		return  $this->subject->path();
	}
    
    protected function updated_reply_title(){
         return $this->subject->event->name;
    }
    

    
    
    
}

