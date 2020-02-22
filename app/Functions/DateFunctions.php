<?php
namespace App\Functions;

use Carbon\Carbon;
use App\User;
use App\Event;
class DateFunctions{
    
public static function averageRatio($data){

$lastmonth=self::byLastMonth($data);
            
/**Get this month user*/            
 $thismonth=self::byThisMonth($data);
            
/** Calcaulate users avaerage ratio */            
return self::calculateRatio($lastmonth,$thismonth);
}
    
public static function byLastMonth($data){
    $fromDate =  self::getStartMonth();
$tillDate = self::getEndMonth();
return $data::whereBetween('created_at',[$fromDate,$tillDate])->count();
}    
    
public static function byThisMonth($data){
return $data::whereYear('created_at', Carbon::now()->year)
->whereMonth('created_at',Carbon::now()->month)->count();
}    
    
    /**Get last user from Start Date*/ 
     private static function getStartMonth(){
       return Carbon::now()->subMonth()->startOfMonth()->toDateString();
    }
     
  /**Get last user from End Date*/     
    private static function getEndMonth(){
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
