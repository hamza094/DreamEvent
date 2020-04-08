<?php

namespace App\Functions;
use DB;
use App\Functions\DateFunctions;
use App\Event;
use App\User;
use App\Topic;
use Newsletter;
use App\PurchaseTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashBoard{

public static function QueryFilters($request){

//Array for record value    
$counters = [];
//Get data with request    
if($request->filled('userRatio')){
    return DateFunctions::averageRatio(User::class);
    
}elseif($request->filled('monthUser')){
    return DateFunctions::byThisMonth(User::class);
    
}elseif($request->filled('users')){
    return User::all()->count();
    
}elseif($request->filled('monthEvent')){
    return DateFunctions::byThisMonth(Event::class); 
    
}elseif($request->filled('eventRatio')){
    return DateFunctions::averageRatio(Event::class);
    
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
    
public static function monthlySalesChart(){
    $monthlySales=DB::table('purchase_tickets')
->select(DB::raw('sum(qty) as total'),DB::raw('monthname(created_at) as months'))
->groupBy('months')
->orderBy('created_at')->whereYear('created_at', Carbon::now()->year)
->get();
return response()->json($monthlySales);
}    

public static function yearlySalesChart(){
    $yearlySales=DB::table('purchase_tickets')
->select(DB::raw('sum(qty) as total'),DB::raw('year(created_at) as years'))
->groupBy('years')
->orderBy('years','asc')
->get();
return response()->json($yearlySales);
}    
    
public static function monthlyRevenueChart(){
    $monthlyRevenue=DB::table('purchase_tickets')
->select(DB::raw('sum(total) as total'),DB::raw('monthname(created_at) as months'))
->groupBy('months')
->orderBy('created_at')->whereYear('created_at', Carbon::now()->year)
->get();
return response()->json($monthlyRevenue);
}    
    
public static function yearlyRevenueChart(){
    $yearlyRevenue=DB::table('purchase_tickets')
->select(DB::raw('sum(total) as total'),DB::raw('year(created_at) as years'))
->groupBy('years')
->orderBy('years','asc')
->get();
return response()->json($yearlyRevenue);
}    
}

?>
