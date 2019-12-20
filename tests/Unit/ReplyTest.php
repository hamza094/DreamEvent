<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;


class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function it_has_owner()
    {
        $reply=create('App\Reply');
        $this->assertInstanceOf('App\User',$reply->user);
    }
}
