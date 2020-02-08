<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
     /** @test */
    public function admin_view_all_events()
    {
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $event=create('App\Event');
         $this->get('/api/allevents')
        ->assertSee($event->name);
    }
    
       /** @test */
    public function admin_view_all_live_events()
    {
        $event=create('App\Event');
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->get('/api/allevents?live=1')
        ->assertSee($event->name);
    }
    
    /** @test*/
     public function admin_view_all_drafted_events()
    {
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->assertCount(1,$event->get());
        $this->delete($event->path());
         $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->withoutExceptionHandling()->get('/api/allevents?drafted=1')
        ->assertSee($event->name); 
         
    }
    
        /** @test */
    public function an_admin_can_search_events()
    {
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        create('App\Event', [], 10);
        create('App\Event', ['name' => 'thanos'], 2);
        $results = $this->withoutExceptionHandling()->getJson('api/findAllEvents/?q=thanos')->json()['data'];
        $this->assertCount(2, $results);
        $this->assertTrue(true);
    }
    
         /** @test */
    public function admin_view_all_users()
    {
         $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $user=create('App\User');
         $this->withoutExceptionHandling()->get('api/users')
        ->assertSee($user->name);
    }
    
      /** @test */
    public function admin_can_delete_a_user()
    {
         $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $user=create('App\User');
        $response=$this->json('DELETE',"api/users/{$user->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users',['id'=>$user->id]);
    }
    
    /** @test */
    public function an_admin_can_search_users()
    {
         $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        create('App\User', [], 10);
        create('App\User', ['name' => 'thanos'], 2);
        $results = $this->getJson('api/findUsers/?q=thanos')->json()['data'];
        $this->assertCount(2, $results);
        $this->assertTrue(true);
    }
    
     /** @test */
    public function an_admin_delete_any_event()
    {
         $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $event=create('App\Event',['user_id'=>$admin->id]);
        $this->get("/events/{$event->slug}/delete");
        $this->assertDatabaseMissing('events',['id'=>$event->id]);
    }
    
}
