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
if($request->filled('userRatio')){
    
   return DateFunctions::averageRatio('App\User');
    
}elseif($request->filled('monthUser')){
        return DateFunctions::byThisMonth('App\User');
    }elseif($request->filled('users')){
      return User::all()->count();
    }
        return response()->json($counters);
    }
    

}
