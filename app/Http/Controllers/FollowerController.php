<?php

namespace App\Http\Controllers;

use App\Event;
use App\Follow;

class FollowerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(Event $event)
    {
        $event->follow();
    }

    public function unfollow(Event $event)
    {
        $event->unfollow();
    }
}
