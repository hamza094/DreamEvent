<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
        use RefreshDatabase;
    /**
     * A basic user test example.
     *
     * @return void
     */
    
     /** @test */
    public function admin_view_all_users()
    {
        $this->signIn();
        $user=create('App\User');
         $this->withoutExceptionHandling()->get('api/users')
        ->assertSee($user->name);
    }
    
      /** @test */
    public function admin_can_delete_a_user()
    {
        $this->signIn();
        $user=create('App\User');
        $response=$this->json('DELETE',"api/users/{$user->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users',['id'=>$user->id]);
    }
}
