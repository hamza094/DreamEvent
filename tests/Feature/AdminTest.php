<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\Ticket;
use Illuminate\Support\Facades\Mail;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * An  Admin Access test.
     *
     * @return void
     */
    
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
        $this->get('/api/allevents?drafted=1')
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
        $results = $this->getJson('api/findAllEvents/?q=thanos')->json()['data'];
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
         $this->get('api/users')
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
    
      /** @test */
    public function admin_view_all_purchase_tickets()
    {
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $ticket=create('App\PurchaseTicket');
         $this->get('/api/tickets')
        ->assertSee($ticket->receipt);
    }
    
    /** @test */
    public function admin_view_all_delivered_purchased_tickets()
    {
        $ticket=create('App\PurchaseTicket',['delivered'=>1]);
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->get('/api/tickets?deliver=1')
        ->assertSee($ticket->receipt);
    }
    
    /** @test */
    public function admin_view_all_undelivered_purchased_tickets()
    {
        $ticket=create('App\PurchaseTicket',['delivered'=>0]);
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->get('/api/tickets?undeliver=1')
        ->assertSee($ticket->receipt);
    }
    
     /** @test */
    public function an_admin_can_delete_any_purchase_ticket()
    {
        $ticket=create('App\PurchaseTicket');
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->delete("api/ticket/{$ticket->id}");
        $this->assertDatabaseMissing('purchase_tickets',['id'=>$ticket->id]);
    }
    
          /** @test */
    public function an_admin_can_search_purchase_tickets()
    {
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        create('App\PurchaseTicket', [], 10);
        create('App\PurchaseTicket', ['receipt' => '7825-8765'], 2);
        $results = $this->withoutExceptionHandling()->getJson('api/findtickets/?q=7825-8765')->json()['data'];
        $this->assertCount(2, $results);
        $this->assertTrue(true);
    }
    
    /** @test */
    public function an_admin_can_deliver_ticker()
    {
        $ticket=create('App\PurchaseTicket',['delivered'=>0]);
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->post("/api/ticket/deliver/{$ticket->id}");
        $ticket->deliver();
        $this->assertTrue($ticket->delivered,1);
    }
    
    /** @test */
    public function admin_sent_ticket_mail(){
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();
        
        $ticket=create('App\PurchaseTicket',['delivered'=>0]);
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $this->post("/api/ticket/deliver/{$ticket->id}");
        $ticket->deliver();
        
           // Assert a message was sent to the given users...
        Mail::assertSent(Ticket::class, function ($mail) use ($ticket) {
            return $mail->hasTo($ticket->user->email);
        });
        
        Mail::assertSent(Ticket::class, 1);
    }
    
}
