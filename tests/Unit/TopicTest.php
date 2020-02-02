<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    /** @test */
    public function a_topic_consist_an_events(){
        $topic=create('App\Topic');
        $event=create('App\Event',['topic_id'=>$topic->id]);
        $this->assertTrue($topic->events->contains($event));
    } 
}
