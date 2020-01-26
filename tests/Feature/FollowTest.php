<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FollowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A Follow feature test.
     *
     * @return void
     */
    
    /** @test */
    public function an_authenticated_user_followed_to_a_event()
    {
        $this->signIn();
        $event=create("App\Event");
        $this->post($event->path().'/follow');
        $this->assertCount(1, $event->followers);
    }
    
    /** @test */
    public function an_authenticated_user_unfollowed_to_a_event()
    {
        $this->signIn();
        $event=create("App\Event");
        $this->delete($event->path().'/follow');
        $this->assertCount(0, $event->followers);
    }
    
     
}
