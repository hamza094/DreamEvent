<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
        /** @test */
    public function if_know_it_was_just_published(){
        $reply=create('App\Reply');
        $this->assertTrue($reply->wasJustPublished());
        $reply->created_at=Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());

    }
    
     /** @test */
    public function a_user_can_fetch_there_last_reply()
    {
        $user=create('App\User');
        $reply=create('App\Reply',['user_id'=>$user->id]);
        $this->assertEquals($reply->id,$user->lastReply->id);
    }
    
    
}
