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
use DB;

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
    
public function sales(){
$monthlySales=DB::table('purchase_tickets')
->select(DB::raw('sum(qty) as total'),DB::raw('monthname(created_at) as months'))
->groupBy('months')
->orderBy('created_at')->whereYear('created_at', Carbon::now()->year)
->get();
return response()->json($monthlySales);
}
    
public function yearlysales(){
    $yearlySales=DB::table('purchase_tickets')
->select(DB::raw('sum(qty) as total'),DB::raw('year(created_at) as years'))
->groupBy('years')
->orderBy('years','asc')
->get();
return response()->json($yearlySales);
}    
 
public function monthrevenue(){
$monthlyRevenue=DB::table('purchase_tickets')
->select(DB::raw('sum(total) as total'),DB::raw('monthname(created_at) as months'))
->groupBy('months')
->orderBy('created_at')->whereYear('created_at', Carbon::now()->year)
->get();
return response()->json($monthlyRevenue);
}

public function yearrevenue(){
$yearlyRevenue=DB::table('purchase_tickets')
->select(DB::raw('sum(total) as total'),DB::raw('year(created_at) as years'))
->groupBy('years')
->orderBy('years','asc')
->get();
return response()->json($yearlyRevenue);
} 
    
}



