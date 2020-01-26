<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test */
    public function follower_user_get_notifications_when_reply_is_made()
    {
        $this->signIn();
        $event=create("App\Event")->follow();
        $this->assertCount(0,auth()->user()->notifications);
        $event->addReply([
            'body'=>'Foobar',
            'user_id'=>auth()->id(),
        ]);
        $this->assertCount(0,auth()->user()->fresh()->notifications);
        $user=create('App\User');
         $event->addReply([
            'body'=>'Foobar',
            'user_id'=>$user->id,
        ]);
        $this->assertCount(1,auth()->user()->fresh()->notifications);
    }
    
          /** @test */
    public function user_get_notifications_when_reply_discussion_is_made()
    {
        $this->signIn();
        $reply=create('App\Reply');
        $this->assertCount(0,$reply->user->notifications);  
        $reply->addDiscussionReply([
          'replybody'=>'Foobar',
          'user_id'=>$reply->user->id,
        ]);
        $this->assertCount(0,$reply->user->notifications);  
        $reply->addDiscussionReply([
          'replybody'=>'Foobar',
          'user_id'=>auth()->id(),
        ]);
        $this->assertCount(1,$reply->user->fresh()->notifications);
      }
    
     /** @test */
    public function user_can_fetch_their_notifications()
    {
        $this->signIn();
        $event=create("App\Event")->follow();
        $event->addReply([
            'body'=>'Foobar',
            'user_id'=>create('App\User')->id,
        ]);
        $user=auth()->user();
        $response=$this->getJson("/profile/{$user->id}/notifications")->json();
        $this->assertCount(1,$response);
    }
    
    /** @test */
    public function a_user_can_clear_a_notification()
    {
        $this->signIn();
        $event=create("App\Event")->follow();
        $event->addReply([
            'body'=>'Foobar',
            'user_id'=>create('App\User')->id,
        ]);
        $user=auth()->user();
        $this->assertCount(1,$user->unreadNotifications);
        $notificationId=$user->unreadNotifications->first()->id;
        $this->delete("/profile/{$user->id}/notifications/{$notificationId}");
        $this->assertCount(0,$user->fresh()->unreadNotifications);
    }
    
         /** @test */
    public function user_get_notifications_when_event_updated()
    { 
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $user1=create('App\User');
        $this->signIn($user1);
        $event->follow();
        $this->assertCount(0,$user1->notifications);
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
        $this->signIn($user);
        $this->patch($event->path(),['name'=>$name,'desc'=>$desc,'strtdt'=>$strtdt,
        'strttm'=>$strttm,'enddt'=>$enddt,'endtm'=>$endtm,'location'=>$loc,'venue'=>$ven,'price'=>$price,'qty'=>$qty]);
        $this->assertCount(1,$user1->fresh()->notifications);
     }
       
}
