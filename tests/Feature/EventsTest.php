<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rules\Recaptcha;

class EventsTest extends TestCase
{
    use RefreshDatabase;
    
        public function setUp(): void
    {
        parent::setUp();
        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }
    
    /** @test */ 
    public function guest_user_cannot_see_createEventPage()
    {
        $this->withExceptionHandling()
        ->get('/event-create')
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_autheticated_user_can_create_an_Event()
    {
        $this->signIn();
        $event=make('App\Event');
        $response=$this->post('/event-create',['name' => 'thanos','desc'=>'deede dede ded','strtdt'=>'14 dec 2010',
        'strttm'=>'9:45','enddt'=>'4 mar','endtm'=>'9:45','location'=>'lhr','price'=>45,'g-recaptcha-response'=>'token','venue'=>'lhr',
        'topic_id'=>1,'qty'=>1,'image_path'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTHZInbmRX8Mtrdptido88vfG9e8tmTPNcYMuYdOTPFjwRE0bAG']);
         $this->assertDatabaseHas('events',['name'=>'thanos']);
    }
    
    /** @test */
    public function a_event_requires_a_name()
    {
         $this->signIn();
    $event=make('App\Event',[
            'name'=>null
        ]);
        $this->post('/event-create',$event->toArray())
            ->assertSessionHasErrors('name');
    }
    
    /** @test */    
    public function a_thread_event_recaptcha_verification(){
        $this->signIn();
        unset(app()[Recaptcha::class]);
        $this->post('/event-create',['g-recaptcha-response'=>'test'])
        ->assertSessionHasErrors('g-recaptcha-response');
        
    }
    
     
    public function a_user_can_search_events()
    {
        $this->signIn();
        create('App\Event', [], 10);
        create('App\Event', ['name' => 'thanos'], 2);
        $results = $this->getJson('api/events/search/?query=thanos')->json()['data'];
        $this->assertCount(2, $results);
        $this->assertTrue(true);
    }
}

