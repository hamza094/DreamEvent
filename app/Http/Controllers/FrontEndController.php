<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Topics;

class FrontEndController extends Controller
{
    public function index(){
        $events=Event::orderBy('created_at','desc')->paginate(8);
        return view('welcome',compact('events'));
    }
}
