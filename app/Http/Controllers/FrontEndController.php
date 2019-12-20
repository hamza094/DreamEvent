<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Topic;
use Illuminate\Support\Facades\Redis;
use App\Trending;
use Illuminate\Support\Facades\Cache;


class FrontEndController extends Controller
{
    public function index(Trending $trending){
          $events=Event::orderBy('created_at','desc')->paginate(8);
        $topics=Topic::all();
//Redis::del('high_events');
         return view('welcome', [
            'events'=>$events,
            'trending'=>$trending->get(),
            'topics'=>$topics
        ]);
    }
}
