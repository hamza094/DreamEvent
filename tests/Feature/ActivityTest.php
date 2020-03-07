<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Activity;
class ActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test */
    public function it_records_activity_when_discussion_reply_is_added()
    {
    $this->signIn();
    $discussionreply=create('App\DiscussionReply');
    $this->assertDatabaseHas('activities', [
            'name' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $discussionreply->id,
            'subject_type' => 'App\Reply'
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $discussionreply->id);
        $this->assertEquals(3, Activity::count());
    }
}
