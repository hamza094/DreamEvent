<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Functions\DateFunctions;
use Carbon\Carbon;

class DashboardController extends Controller
{
    
public function index(Request $request){
$counters = [];
if($request->filled('user')) {
   return DateFunctions::userRation();
   
    }elseif($request->filled('event')){
        return Event::all()->count();
    }
        return response()->json($counters);
    }
    

}
