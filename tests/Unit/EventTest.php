<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
       /** @test */
    public function a_event_can_make_a_string_path(){
        $event=create('App\Event');
        $this->assertEquals(
            "/events/{$event->slug}",$event->path());
    }
    
    
    /** @test */
    public function a_event_has_a_creator()
    {
        $event=create('App\Event');
        $this->assertInstanceOf('App\User',$event->user);
    }
    
     /** @test */
    public function it_belongs_to_a_project()
    {
        $event = create('App\Event');
        $this->assertInstanceOf('App\Topic', $event->topic);
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
    
    /** @test */
    public function an_event_can_be_followed_to(){
        $event=create('App\Event');
        $event->follow($userId=1);
        $this->assertEquals(1,$event->followers()->where('user_id',$userId)->count());
    }
    
     /** @test */
    public function an_event_can_be_unfollowed_from()
    {
        $event = create('App\Event');
        $event->follow($userId = 1);
        $event->unfollow($userId);
        $this->assertCount(0, $event->followers);
    }
    
         /** @test */
    public function authenticated_user_followed_to()
    {
        $event = create('App\Event');
        $this->signIn();
        $this->assertFalse($event->isFollowedTo);
        $event->follow();
        $this->assertTrue($event->isFollowedTo);
        
   }
    

}
