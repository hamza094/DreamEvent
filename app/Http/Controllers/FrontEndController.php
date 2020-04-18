<?php

namespace App\Http\Controllers;

use App\Event;
use App\PurchaseTicket;
use App\Topic;
use App\Trending;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Mail;
use Newsletter;
use PDF;
use Stripe\Charge;
use Stripe\Stripe;

class FrontEndController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only'=>[
                'buy', 'mail'
            ]
        ]);
    }

    public function index(Trending $trending)
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(8);
        $topics = Topic::all();
        //Redis::del('high_events');
        return view('welcome', [
            'events'=>$events,
            'trending'=>$trending->get(),
            'topics'=>$topics
        ]);
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'subscriber'=>'required|email',
        ]);
        $subscriber = request('subscriber');
        Newsletter::subscribe($subscriber);

        if (request()->wantsJson()) {
            return response(['status'=>'Subscribed succesfull']);
        }
    }

    public function buy(Request $request, Event $event)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        //Charge User
        $charge = Charge::create([
            'amount' =>request('selectedprice') * 100,
            'currency' => 'usd',
            'description' => "$event->name Ticket Charge",
            'source' => request('stripeToken'),
        ]);

        //Get required card information
        $last4 = $charge->source->last4;
        $brand = $charge->source->brand;
        $customerId = $charge->source->customer;

        //generate random number for invoice
        $num = mt_rand(1000, 9999);
        $num2 = mt_rand(1000, 9999);
        $real_num = $num.'-'.$num2;

        //handle purchase ticket on server side
        $buy = PurchaseTicket::create([
            'total'=>request('selectedprice'),
            'user_id'=>auth()->user()->id,
            'event_id'=>$event->id,
            'qty'=>request('selectedqty'),
            'receipt'=>$real_num
        ]);
        $event->update(
            [
                'qty'=>$event->qty - request('selectedqty'),
                'sold'=>$event->sold + request('selectedqty')
            ]
        );

        $data = [
            'subject'=>'Event Ticket Receipt',
            'name'=>auth()->user()->name,
            'eventName'=>$event->name,
            'total'=>request('selectedprice'),
            'qty'=>request('selectedqty'),
            'price'=>$event->price,
            'eventSlug'=>$event->slug,
            'user'=>auth()->user()->email,
            'brand'=>$brand,
            'last4'=>$last4,
            'recipt'=>$real_num,
            'date'=>Carbon::now()->toDateTimeString(),
        ];

        $pdf = PDF::loadView('emails.ticket', $data)->setPaper('a4'); //send pdf receipt with mail
        Mail::send('emails.ticket', $data, function ($message) use ($data,$pdf) {
            $message->from('dreamevent@gmail.com');
            $message->to($data['user']);
            $message->subject($data['subject']);
            $message->attachData($pdf->output(), 'invoice.pdf');
        });

        if (request()->wantsJson()) {
            return response(['status'=>'Purchased succesfull']);
        }
    }

    public function mail(Request $request, Event $event)
    {
        $this->validate($request, [
            'subject'=>'required',
            'body'=>'required',
        ]);

        $data = [
            'subject'=>$request->subject,
            'body'=>$request->body,
            'name'=>auth()->user()->name,
            'eventName'=>$event->name,
            'eventSlug'=>$event->slug,
            'user'=>auth()->user()->email,
            'organizer'=>$event->user->email
        ];
        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['user']);
            $message->to($data['organizer']);
            $message->subject($data['subject']);
        });

        return response(['status'=>'mail sent successfully']);
    }

    public function template()
    {
        return view('emails.ticket');
    }
}
