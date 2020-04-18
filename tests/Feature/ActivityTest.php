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
    public function when_discussion_reply_is_added()
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
    
     /** @test */
    public function creating_a_event()
    {
        $event=create('App\Event');
        $this->assertCount(2,$event->activity);
       tap($event->activity->last(), function ($activity) {
             $this->assertEquals('updated_event',$activity->name);
            //$this->assertNull($activity->changes);
        });
    }
    
    /** @test*/
     public function updating_a_project()
    {
        $event=create('App\Event');
        $originalTitle = $event->name;
         $originalSlug=$event->slug;
        $event->update(['name'=>'changed','slug'=>'changed']);
        $this->assertCount(3,$event->activity);
        tap($event->activity->last(), function ($activity) use ($originalTitle,$originalSlug) {
            $this->assertEquals('updated_event',$activity->name);
              $expected = [
                'before' => ['name' => $originalTitle,'slug'=>$originalSlug],
                'after' => ['name' => 'changed','slug'=>'changed']
            ];
            $this->assertEquals($expected, $activity->changes);
        });
    }
    
       /** @test */
    public function buying_event_ticket()
    {
        $ticket=create('App\PurchaseTicket');
        $this->assertCount(1,$ticket->activity);
    }
    
        /** @test */
    public function diliver_ticket_user()
    {
        $ticket=create('App\PurchaseTicket',['delivered'=>0]);
        $ticket->deliver();
        $this->assertEquals($ticket->delivered,1);
        $this->assertCount(2,$ticket->activity);
    }
    
}
