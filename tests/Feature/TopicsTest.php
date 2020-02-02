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
        $topics=create('App\Topic');
         $this->get('/api/topics')
        ->assertSee($topics->name);
    }
    
    /** @test */
    public function topic_must_required_a_name()
    {
        $this->signIn();
        $topic=make('App\Topic',[
            'name'=>null
        ]);
        $this->post('/api/topics',$topic->toArray())
            ->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function an_admin_can_add_a_topic()
    {
        $this->signIn();
       $topic=create('App\Topic');
        $this->post('/api/topics',$topic->toArray())
            ->assertStatus(200);
    }    
        
      /** @test */
    public function an_event_requires_a_unique_slug()
    {
      $this->signIn();
      create('App\Topic',[],2);
      $topic=create('App\Topic',['name'=>'Foo Title']);
      $this->assertEquals($topic->fresh()->slug,'foo-title');
      $topic2=create('App\Topic',['name'=>'Foo Title']);
      $this->assertEquals("foo-title-{$topic2['id']}", $topic2['slug']);
   }
    
    /** @test */
    public function admin_can_delete_a_topic()
    {
        $this->signIn();
        $topic=create('App\Topic');
        $event=create('App\Event',['topic_id'=>$topic->id]);
        $response=$this->json('DELETE',"/api/topics/{$topic->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('topics',['id'=>$topic->id]);

    }
  
    /** @test */
    public function an_admin_can_update_a_topic()
    {
        $this->signIn();
        $topic=create('App\Topic');
        $Updatedname='Assemble';
        $Updatedcreated='Cap';
        $this->patch("/api/topics/{$topic->id}",['name'=>$Updatedname,'created_by'=>$Updatedcreated]);
        $this->assertDatabaseHas('topics',['id'=>$topic->id,'name'=>$Updatedname]);
    }
     
    /** @test */
    public function guest_can_topic_related_events(){
        $topic=create('App\Topic');
        $this->withoutExceptionHandling()->get("topic/{$topic->slug}")->assertSee($topic->name);
    }
}
