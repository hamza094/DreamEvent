<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Event;

class EvenetTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    /** @test */
    public function a_event_has_a_creator()
    {
        $event=create('App\Event');
        $this->assertInstanceOf('App\User',$event->user);
    }
    
      /** @test */
    public function a_event_can_add_a_reply()
    {
        $this->signIn();
        $event=create('App\Event');
        $event->addReply([
            'body'=>'Foobar',
            'user_id'=>1
        ]);
        
        $this->assertCount(1,$event->replies);
    }
    
  
}
