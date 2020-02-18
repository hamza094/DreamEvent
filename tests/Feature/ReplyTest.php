<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    
     /**
     * A Discussion feature test.
     *
     * @return void
     */
    
      public function setup(): void
      {
        parent::setUp();
        $this->event=factory('App\Event')->create();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function a_user_can_read_replies_related_to_events()
    {
        $event=create('App\Event');
        $reply=create('App\Reply', ['event_id' => $event->id], 2);
        $this->get($event->path())->
        assertSee($reply->body);
        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    } 
    
        /** @test */
    public function an_authenticated_user_may_participate_in_event_discussion()
    {
        $this->signIn();
        
        $reply=factory('App\Reply')->create();
        
        $this->post($this->event->path()."/replies",$reply->toArray());
        
        $this->assertDatabaseHas('replies',['body'=>$reply->body]);
        //$this->get($this->event->path())->assertSee($reply->body);
        //$this->assertEquals(1,$event->fresh()->replies_count); 
    }
    
        /** @test */
  public function replies_that_contain_spam_may_not_be_created(){
      $this->signIn();
       $reply=make('App\Reply',[
          'body'=>'Yahoo Customer Support' 
       ]);
      $this->json('post',$this->event->path().'/replies',$reply->toArray())
          ->assertStatus(422);
  }   
    
    /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    { 

      $this->signIn();
        
        $reply=create('App\Reply');
        
      $this->post($this->event->path().'/replies',$reply->toArray());
        
        $this->post($this->event->path().'/replies',$reply->toArray())
          ->assertStatus(422);
        
    }
    
        /** @test */
    public function authorized_user_can_update_reply()
    {
        $user=create('App\User');
        $user2=create('App\User');
        $this->signIn($user);
        $reply=create('App\Reply',['user_id'=>$user->id]);
        $Updatedbody='Avengers Assemble';
        $this->patch("/replies/$reply->id",['body'=>$Updatedbody,'user_id'=>$user->id]);
        $this->assertDatabaseHas('replies',['id'=>$reply->id,'body'=>$Updatedbody]);
    }
    
    /** @test */   
    public function authorized_user_can_delete_a_reply()
    {
        $user=create('App\User');
        $this->signIn($user);
        $reply=create('App\Reply',['user_id'=>$user->id]);
        $response=$this->json('DELETE',"/replies/{$reply->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
    }
  
}
