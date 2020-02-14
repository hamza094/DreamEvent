<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    /** @test */
    public function ticket_can_be_delivered()
    {
        $ticket=create('App\PurchaseTicket',['delivered'=>0]);
        $ticket->deliver();
        $this->assertEquals($ticket->delivered,1);
    }
}
