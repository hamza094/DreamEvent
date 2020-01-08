<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class ReplyDiscussionTest extends TestCase
{
    use RefreshDatabase;
    
      public function setup(): void
      {
        parent::setUp();
        $this->reply=factory('App\Reply')->create();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function an_authenticated_user_may_participate_in_discussion_replies()
    {
        $this->signIn();
        
        $discussionreply=factory('App\DiscussionReply')->create();
        
        $this->withoutExceptionHandling()->post("/discussion/{$this->reply->id}",$discussionreply->toArray());
        
        $this->assertDatabaseHas('discussion_replies',['replybody'=>$discussionreply->replybody]); 
    }
    
          /** @test */
    public function authorized_user_can_update_discussion_reply()
    {
        $user=create('App\User');
        $this->signIn($user);
        $discussionreply=create('App\DiscussionReply',['user_id'=>$user->id]);
        $Updatedbody='Avengers Assemble';
        $this->patch("/discussionreply/$discussionreply->id",['replybody'=>$Updatedbody,'user_id'=>$user->id]);
        $this->assertDatabaseHas('discussion_replies',['id'=>$discussionreply->id,'replybody'=>$Updatedbody]);
    }
    
    /** @test */
      /** @test */   
    public function authorized_user_can_delete_a_reply()
    {
        $user=create('App\User');
        $this->signIn($user);
        $discussionreply=create('App\DiscussionReply',['user_id'=>$user->id]);
        $response=$this->withoutExceptionHandling()->json('DELETE',"/discussionreply/{$discussionreply->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('discussion_replies',['id'=>$discussionreply->id]);
    }
    
    
    
}
