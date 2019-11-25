<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test */
    public function admin_view_all_topics()
    {
        $this->signIn();
        $topics=create('App\Topics');
         $this->get('/api/topics')
        ->assertSee($topics->name);
    }
    
    /** @test */
    public function topic_must_required_a_name()
    {
        $this->signIn();
        $topic=make('App\Topics',[
            'name'=>null
        ]);
        $this->post('/api/topics',$topic->toArray())
            ->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function an_admin_can_add_a_topic()
    {
        $this->signIn();
       $topic=create('App\Topics');
        $this->post('/api/topics',$topic->toArray())
            ->assertStatus(200);
    }    
        
    /** @test */
    public function admin_can_delete_a_topic()
    {
        $this->signIn();
        $topic=create('App\Topics');
        $response=$this->json('DELETE',"/api/topics/{$topic->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('topics',['id'=>$topic->id]);
    }
  
    /** @test */
    public function an_admin_can_update_a_topic()
    {
        $this->signIn();
        $topic=create('App\Topics');
        $Updatedname='Assemble';
        $Updatedcreated='Cap';
        $this->patch("/api/topics/{$topic->id}",['name'=>$Updatedname,'created_by'=>$Updatedcreated]);
        $this->assertDatabaseHas('topics',['id'=>$topic->id,'name'=>$Updatedname]);
    }

}
