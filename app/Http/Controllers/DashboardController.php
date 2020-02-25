<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Topic;
use App\Functions\DateFunctions;
use Carbon\Carbon;
use Newsletter;
use App\PurchaseTicket;

class DashboardController extends Controller
{
    
public function index(Request $request){
$counters = [];
if($request->filled('userRatio')){
    
return DateFunctions::averageRatio('App\User');
    
}elseif($request->filled('monthUser')){
    
return DateFunctions::byThisMonth('App\User');
    
}elseif($request->filled('users')){
    
return User::all()->count();
    
}elseif($request->filled('monthEvent')){
    
   return DateFunctions::byThisMonth('App\Event'); 
    
}elseif($request->filled('eventRatio')){
    
    return DateFunctions::averageRatio('App\Event');
    
}elseif($request->filled('events')){
    return Event::all()->count();
}elseif($request->filled('topics')){
    return Topic::all()->count();
}elseif($request->filled('subscribe')){
    $subscriber=Newsletter::getMembers();
    return $subscriber['total_items'];
}elseif($request->filled('tickets')){
    $qty=PurchaseTicket::pluck('qty');
    return $qty->sum();
}elseif($request->filled('ticketRatio')){
    return DateFunctions::TicketRatio();
}elseif($request->filled('ticketMonth')){
    return DateFunctions::TicketThisMonth();
}
return response()->json($counters);
}
    

}
