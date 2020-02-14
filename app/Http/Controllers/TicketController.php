<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PurchaseTicket;
use Mail;
use App\Mail\Ticket;
use Auth;

class TicketController extends Controller
{
    public function index(){
        if(request('deliver')){
          return PurchaseTicket::where('delivered',1)->with('event','user')->paginate(15); 
        }
        elseif(request('undeliver')){
            return PurchaseTicket::where('delivered',0)->with('event','user')->paginate(15);
        }
        else{
        return PurchaseTicket::latest()->with('event','user')->paginate(15); 
        }
    }
    
    public function ticketcount(){
        return PurchaseTicket::all()->count(); 
    }
    
     public function delivered(){
        return PurchaseTicket::all()->where('delivered',1)->count(); 
    }
    public function destroy(PurchaseTicket $ticket){
        $ticket->delete();
    }
    
    public function search(){
        if ($search = \Request::get('q')) {
            $tickets = PurchaseTicket::where(function($query) use ($search){
                $query->where('receipt','LIKE',"%$search%");
            })->with('event','user')->paginate(15);
        }else{
               $tickets= PurchaseTicket::latest()->with('event','user')->paginate(15);
        }
        return $tickets;
    }
    
    public function deliver(PurchaseTicket $ticket){
        $ticket->deliver();
        
        //Send Ticket Mail
        Mail::to($ticket->user->email)->send(
            new Ticket($ticket)
        );
    }

    
}
