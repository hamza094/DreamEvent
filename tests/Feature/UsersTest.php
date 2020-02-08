<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UsersTest extends TestCase
{
        use RefreshDatabase;
    /**
     * A basic user test example.
     *
     * @return void
     */
    
    
    public function user_session_validation(){
        $this->signIn();
     $user=create('App\User');
         $this->patch("/profile/{$user->id}",[
            'name'=>'Changed',
             'backimg'=>'Changed'
            ])->assertSessionHasErrors('email');
    }
    
    
    /** @test */
    public function user_view_profile()
    {
        $this->signIn();
        $user=create('App\User');
        $this->get("/profile/{$user->id}")
            ->assertSee($user->name);
    }
    
       /** @test */
    public function user_can_not_update_any_profile()
    {
        $user=create('App\User');
        $this->signIn();
        $Updatedname='Assemble';
        $UpdatedEmail='Cap_avenge@yahoo.com';
        $backimage='https://i.ibb.co/4SRVMQj/654853-user-men-2-512.png';
        $this->patch("profile/{$user->id}",['name'=>$Updatedname,'email'=>$UpdatedEmail,'backimg'=>$backimage])
            ->assertStatus(403);
        $this->assertDatabaseMissing('users',['id'=>$user->id,'name'=>$Updatedname]);
    }
    
       /** @test */
    public function profile_owner_can_update_his_profile()
    {
        $user=create('App\User');
        $this->signIn($user);
        $Updatedname='Assemble';
        $UpdatedEmail='Cap_avenge@yahoo.com';
        $backimage='https://i.ibb.co/4SRVMQj/654853-user-men-2-512.png';
        $this->patch("profile/{$user->id}",['name'=>$Updatedname,'email'=>$UpdatedEmail,'backimg'=>$backimage]);
        $this->assertDatabaseHas('users',['id'=>$user->id,'name'=>$Updatedname]);
    }

    /** @test */
    public function only_members_can_add_avatars()
    {
      $this->withExceptionHandling();
        $this->json('POST','api/profile/1/avatar')
            ->assertStatus(401);
    }
    
    /** @test */
    public function a_valid_avatar_must_be_provided(){
        $this->withExceptionHandling()->signIn();
        $this->json('POST','api/profile/'.auth()->id().'/avatar',[
           'avatar'=>'not-an-image' 
        ])->assertStatus(422);
    }
    
    
    public function a_user_may_add_avatar_to_thier_profile()
    {
      $this->signIn();
        Storage::fake('s3');
        $this->json('POST','api/profile/'.auth()->id().'/avatar',[
            'avatar'=>$file=UploadedFile::fake()->image('avatar.jpg')
        ]);
        $this->assertEquals($file->hashName(),auth()->user()->avatar_path);
        Storage::disk('s3')->assertExists('avatars/'.$file->hashName());
    }
    
    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
    $user=create('App\User');
    $user->avatar_path='http://localhost/storage/avatars/me.jpg';
    $this->assertEquals(asset('storage/avatars/me.jpg'),$user->avatar_path);
    }
    
    
    public function guest_user_subscribe_newsleter(){
       $this->post('/subscribe',['subscriber' => 'hamza_pisces@live.com'])
           ->assertStatus(200);
    }
    
    /** @test */
    public function authenticated_user_see_his_created_events(){
        $event=create('App\Event');
        $this->get('/myevents')->assertRedirect('/login');
        $user=create('App\User');
        $this->signIn($user);
        $event=create('App\Event',['user_id'=>$user->id]);
        $this->get('/myevents')->assertSee($event->name);
    }
    
    /** @test */
    public function authenticated_user_can_see_events_his_participated_events(){
        $this->signIn();
        $user=create('App\User');
        $ticket=create('App\PurchaseTicket',['user_id'=>$user->id]);
        $this->get("/profile/{$user->id}")
            ->assertSee($ticket->event->name);
    }
    
    
}
