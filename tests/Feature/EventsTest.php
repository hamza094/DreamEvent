<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rules\Recaptcha;
use App\Activity;
class EventsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * An  Event Feature test.
     *
     * @return void
     */
    
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
        $originalName=$event->name;
        $topic=create('App\Topic');
        $response=$this->post('/events',['name' => 'thanos','desc'=>'deede dede ded','strtdt'=>2019-12-22,
        'strttm'=>'9:45','enddt'=>2019-12-23,'endtm'=>'9:45','location'=>'lhr','price'=>45,'g-recaptcha-response'=>'token','venue'=>'lhr',
        'topic_id'=>$topic->id,'qty'=>1,'image_path'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTHZInbmRX8Mtrdptido88vfG9e8tmTPNcYMuYdOTPFjwRE0bAG']);
         $this->assertDatabaseHas('events',['name'=>'thanos']);
        //$this->assertCount(1,$topic->events_count);
    }
    
    /** @test */
    public function a_event_requires_a_name()
    {
         $this->signIn();
    $event=make('App\Event',[
            'name'=>null
        ]);
        $this->post('/events',$event->toArray())
            ->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function an_event_requires_a_unique_slug(){
        $this->signIn();
        create('App\Event',[],2);
        $event=create('App\Event',['name'=>'Foo Title']);
        $this->assertEquals($event->fresh()->slug,'foo-title');
    $event2=create('App\Event',['name'=>'Foo Title']);
    $this->assertEquals($event2->fresh()->slug,'foo-title-2');
   }
    
    
    /** @test */    
    public function a_thread_event_recaptcha_verification(){
        $this->signIn();
        unset(app()[Recaptcha::class]);
        $this->post('/events',['g-recaptcha-response'=>'test'])
        ->assertSessionHasErrors('g-recaptcha-response');
    }
    
    /** @test */
    public function guest_can_visit_single_events_page(){
        $topic=create('App\Topic');
        $event=create('App\Event',['topic_id'=>$topic->id]);
        $response=$this->get($event->path())
        ->assertSee($event->name);
    }
    
      /** @test */
    public function guest_can_view_all_events(){
        $event=create('App\Event');
        $this->get('/api/events')->assertSee($event->name);
    }
    
     /** @test */
    public function guest_can_search_events()
    {
        create('App\Event', [], 10);
        create('App\Event', ['name' => 'thanos'], 2);
        $results = $this->getJson('api/findEvents/?q=thanos')->json()['data'];
        $this->assertCount(2, $results);
        $this->assertTrue(true);
    }
    
    /** @test*/
    public function authenticated_user_visit_edit_evant_page()
    {
        $user=create('App\User');
        $this->signIn($user);
        $topic=create('App\Topic');
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->get($event->path().'/edit')
            ->assertSee($event->name);

    
    }
    
     /** @test */
    public function authenticated_user_update_his_event()
    { 
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $name="kola bola";
        $desc='lorem ipsum jipsum';
        $strtdt=2019-12-22;
        $strttm="9:45";
        $enddt=2019-12-22;
        $endtm="14 dec 2010";
        $loc="lhr";
        $ven="Plazza Hotel";
        $price=45;
        $qty=2;
        $this->withoutExceptionHandling()->patch($event->path(),['name'=>$name,'desc'=>$desc,'strtdt'=>$strtdt,
    'strttm'=>$strttm,'enddt'=>$enddt,'endtm'=>$endtm,'location'=>$loc,'venue'=>$ven,'price'=>$price,'qty'=>$qty]);
        $this->assertDatabaseHas('events',['id'=>$event->id,'desc'=>$desc]);

    }
    
    /** @test */
    public function authenticated_user_delete_his_event()
    {
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->get("/events/{$event->slug}/delete");
        $this->assertDatabaseMissing('events',['id'=>$event->id]);
    }
    
    /** @test */
    public function authenticated_user_draft_his_events()
    {
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->assertCount(1,$event->get());
        $this->delete($event->path());
        $this->assertCount(0,$event->get());
        $this->assertCount(1,$event->withTrashed()->get());
    }
    
     /** @test */
    public function authenticated_user_undraft_his_events()
    {
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->delete($event->path());
        $this->assertCount(0,$event->get());
        $this->assertCount(1,$event->withTrashed()->get());
        $this->withoutExceptionHandling()->get("/events/{$event->slug}/undrafted");
        $this->assertCount(1,$event->get());
    }
    
    /** @test */
    public function event_update_session_validation(){
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->withExceptionHandling()->patch($event->path(),[
        'name'=>'Changed',
        'strtdt'=>'Changed',
        'strttm'=>"Changed",
        'enddt'=>"Changed",
        'endtm'=>"Changed",
        'location'=>"Changed",
        'venue'=>"Changed",
        'price'=>45,
        'qty'=>2,
        ])->assertSessionHasErrors('desc');
    }

}