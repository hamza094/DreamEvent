<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JacobBennett\StripeTestToken;
use Stripe\Charge;
use Stripe\Stripe;

class DreamTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A  DreamEvent Application test.
     *
     * @return void
     */

    public function a_guest_can_visit_welcome_page()
    {
        $this->get('/')->assertStatus(200);
    }

    
    /** @test */
    public function guest_can_see_event_calender(){
        $event=create('App\Event',['strtdt'=>\Carbon\Carbon::now()->toDateTimeString()]);
        $this->get('/fullcalender')
            ->assertSee($event->name);
    }
    
     /** @test */
    public function guest_can_see_topic_related_events(){
        $topic=create('App\Topic');
        $event=create('App\Event',['topic_id'=>$topic->id]);
        $this->withoutExceptionHandling()->get("topic/{$topic->slug}")->assertSee($event->name);
    }

    
   public function guest_user_subscribe_newsleter(){
       $this->post('/subscribe',['subscriber' => 'hamza_pisces@live.com'])
           ->assertStatus(200);
    }
    
}
