<?php
namespace App\Functions;

use Carbon\Carbon;
use App\User;
use App\Event;

class DateFunctions{
    
public static function userRation(){
/**Get last user from last mont*/           
$fromDate =  self::getUserStartMonth();
$tillDate = self::getUserEndMonth();
$lastmonth=User::whereBetween('created_at',[$fromDate,$tillDate])->count();
            
/**Get this month user*/            
 $thismonth=User::whereYear('created_at', Carbon::now()->year)
->whereMonth('created_at',Carbon::now()->month)->count();
            
/** Calcaulate users avaerage ratio */            
return self::calculateRatio($lastmonth,$thismonth);
}
    /**Get last user from Start Date*/ 
     private static function getUserStartMonth(){
       return Carbon::now()->subMonth()->startOfMonth()->toDateString();
    }
     
  /**Get last user from End Date*/     
    private static function getUserEndMonth(){
       return Carbon::now()->subMonth()->endOfMonth()->toDateString();
          
    }

/**Get average ratio*/    
private static function calculateRatio($lastmonth, $thismonth){
    $join=$lastmonth+$thismonth;
    $first=($lastmonth/$join)*100;
    $second=($thismonth/$join)*100;
    $total=$second-$first;
    return $total;
}
}
