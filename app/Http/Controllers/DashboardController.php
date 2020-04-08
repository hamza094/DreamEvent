<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Functions\DashBoard;
use App\Http\Resources\Activity as ActivityResource;

class DashboardController extends Controller
{
    
//Filter query by request    
public function index(Request $request){
  return DashBoard::QueryFilters($request);
}
    
//Get monthly sales chart   
public function sales(){
return DashBoard::monthlySalesChart();
}
    
//Get yearly sales chart        
public function yearlysales(){
return DashBoard::yearlySalesChart();
}   
    
//Get monthly revenue chart    
public function monthrevenue(){
return DashBoard::monthlyRevenueChart();
}
    
//Get monthly revenue chart    
public function yearrevenue(){
return DashBoard::yearlyRevenueChart();
} 

//Get DreamEvent Recent Activities    
public function activity(){
    $activity=ActivityResource::collection(Activity::latest()->paginate(15));
    //$activities=Activity::orderBy('created_at','desc')->with('user','subject')->get();
    return $activity;
}    
    
}



