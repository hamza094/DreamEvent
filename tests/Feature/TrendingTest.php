<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Trending;

class TrendingTest extends TestCase
{
    use RefreshDatabase;
    
      public function setUp(): void
    {
        parent::setUp();
        $this->trending=new Trending();
        Redis::del($this->trending->cacheKey());
    }
    
    /**
     * A basic feature for trending Event.
     *
     * @return void
     */
    
    /** @test */
    public function it_increments_a_event_score_each_time_its_read()
    {
        $this->assertEmpty($this->trending->get());
        $event=create('App\Event');
        $this->call('GET',$event->path());
        $trending=$this->trending->get();
        $this->assertCount(1,$trending);
        $this->assertEquals($event->name,$trending[0]->name);
        $this->assertEquals($event->location,$trending[0]->location);
        
    }
}
