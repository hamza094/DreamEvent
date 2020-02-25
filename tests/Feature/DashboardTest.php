<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Carbon\Carbon;
use App\Functions\DateFunctions;

class DashboardTeast extends TestCase
{
    use RefreshDatabase;
    /**
     * A Dashboard test.
     *
     * @return void
     */
    
    /** @test */
    public function dashboard_count_models()
    {
        $users=create('App\User',[],10);
        $user_count=$users->count();
        $events=create('App\Event',[],10);
        $tickets=create('App\PurchaseTicket',['qty'=>2],10);
        $qty=$tickets->pluck(['qty']);
        
        $admin=create('App\User');
        config(['dream.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $content=$this->withoutExceptionHandling()->get('/api/dashboard')
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals(20,$qty->sum());
        $this->assertEquals(10,$users->count());
        $this->assertEquals(10,$events->count());
    }
    
    /** @test */
    public function calculate_avarage_ratio(){
        $lastmonth=3;
        $thismonth=7;
        $ratio=DateFunctions::calculateRatio($lastmonth,$thismonth);
        $this->assertEquals(40,$ratio);
    }
    
    
}
