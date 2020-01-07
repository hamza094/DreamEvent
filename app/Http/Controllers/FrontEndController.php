<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Topic;
use Illuminate\Support\Facades\Redis;
use App\Trending;
use Illuminate\Support\Facades\Cache;
use Newsletter;
use Stripe\Stripe;
use Stripe\Charge;
use App\PurchaseTicket;
use Mail;
use Auth;

class FrontEndController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth',[
            'only'=>[
                'buy','mail'
            ]
        ]);   
    }
    
    public function index(Trending $trending){
          $events=Event::orderBy('created_at','desc')->paginate(8);
        $topics=Topic::all();
//Redis::del('high_events');
         return view('welcome', [
            'events'=>$events,
            'trending'=>$trending->get(),
            'topics'=>$topics
        ]);
    }
    
    public function subscribe(Request $request){
        $this->validate($request,[
            'subscriber'=>'required|email',
        ]);
      $subscriber=request('subscriber');
      Newsletter::subscribe($subscriber);
        
         if (request()->wantsJson()) {
            return response(['status'=>'Subscribed succesfull']);
        }
    }
    
    public function buy(Request $request,Event $event){
   Stripe::setApiKey("sk_test_T9ilml4rZL3nd3wOKEA11afC00RyjZdPUD");
   $charge=Charge::create([
       'amount' =>request('selectedprice')*100,
       'currency' => 'usd',
       'description' => "$event->name Ticket Charge",
       'source' => request('stripeToken'),
        'receipt_email' => request('stripeEmail'),

]);
    
          $buy=PurchaseTicket::create([
          'total'=>request('selectedprice'),
          'user_id'=>auth()->user()->id,
           'event_id'=>$event->id,  
          'qty'=>request('selectedqty'),
     ]);
        $event->update(['qty'=>$event->qty - request('selectedqty')]);
            if (request()->wantsJson()) {
            return response(['status'=>'Purchased succesfull']);
        }
   }
    
    public function mail(Request $request,Event $event)
    {
          $this->validate($request,[
            'subject'=>'required',
            'body'=>'required',
        ]);
        
        $data=array(
        'subject'=>$request->subject,
        'body'=>$request->body,
        'name'=>auth()->user()->name,
        'eventName'=>$event->name,
        'eventSlug'=>$event->slug,    
        'user'=>auth()->user()->email,
        'organizer'=>$event->user->email    
        );
        Mail::send('emails.contact',$data,function($message) use ($data) {
            $message->from($data['user']);
            $message->to($data['organizer']);
            $message->subject($data['subject']);
            });
        return response(['status'=>'mail sent successfully']);
        
    }
}
