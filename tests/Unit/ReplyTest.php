<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;


class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function it_has_owner()
    {
        $reply=create('App\Reply');
        $this->assertInstanceOf('App\User',$reply->user);
    }
    
      /** @test */
    public function it_generates_the_correct_path_for_paginated_links(){
        $event=create('App\Event');
        $replies=create('App\Reply',['event_id'=>$event->id],3);
        config(['dream.pagination.perPage'=>1]);
        $this->assertEquals($event->path().'?page=1#reply-1',$replies->first()->path());
        $this->assertEquals($event->path().'?page=2#reply-2',$replies[1]->path());
        $this->assertEquals($event->path().'?page=3#reply-3',$replies->last()->path());
    }
}
