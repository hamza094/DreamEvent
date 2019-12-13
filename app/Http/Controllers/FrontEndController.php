<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Topic;

class FrontEndController extends Controller
{
    public function index(){
        $events=Event::orderBy('created_at','desc')->paginate(8);
        $topics=Topic::all();
        return view('welcome',compact('events','topics'));
    }
}
