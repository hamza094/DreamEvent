<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

use App\Rules\Recaptcha;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redis;
use Auth;
use App\Trending;
use Spatie\Searchable\Search;
use Session;
use App\Topic;
use Validator;
use Storage;
use File;
use Image;
use App\PurchaseTicket;
use App\User;
use Carbon\Carbon;

//use GuzzleHttp\Client as GuzzleClient;


class EventsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function __construct()
    {
      $this->middleware('auth',[
            'only'=>[
                'create','store','update','delete'
            ]
        ]);   
    }
   public function index(){
       $events=Event::orderBy('created_at','desc')->paginate(8);
       return view('event.all',compact('events'));
   }
    
    public function events()
    {
         return Event::latest()->paginate(16); 
    } 
    
      public function eventsearch(){
             if ($search = \Request::get('q')) {
            $events = Event::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('location','LIKE',"%$search%");
            })->paginate(16);
        }else{
            $events = Event::latest()->paginate(16);
        }
        return $events;
    }
    
      public function search(Request $request)
    {
       /* $results = (new Search())
    ->registerModel(Event::class, ['name'])
    ->search($request->input('query'));
    
    return response()->json($results);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events=Event::orderBy('created_at','desc')->paginate(8);
         $topics = Topic::all();
        return view('event.create',compact('topics','events'))->with('status', 'Profile updated!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Recaptcha $recaptcha)
    {
       

        $this->validate($request,[
           'name'=>'required',
            'desc'=>'required',
            'strtdt'=>'required',
            'strttm'=>'required',
            'endtm'=>'required',
            'location'=>'required',
            'price'=>'required',
            'topic_id'=>'required',
            'venue'=>'required',
            'qty'=>'required',
            //'image'=>'required',
            'g-recaptcha-response'=>['required', $recaptcha]
        ]);
        
        
       $event=Event::create([
           'name'=>request('name'),
           'user_id'=>auth()->id(),
           'desc'=>request('desc'),
           'strtdt'=>request('strtdt'),
           'enddt'=>request('enddt'),
           'strttm'=>request('strttm'),
           'endtm'=>request('endtm'),
           'location'=>request('location'),
           'price'=>request('price'),
           'qty'=>request('qty'),
           'venue'=>request('venue'),
           'topic_id'=>request('topic_id')
           ]);
        $user = Auth::user();
    $file = $request->file('image');
    $filename=uniqid($user->id."_").".".$file->getClientOriginalExtension();  
    Storage::disk('s3')->put($filename,File::get($file),'public');
    $image_path=Storage::disk('s3')->url($filename);
    $event->update(['image_path'=>$image_path]);
        
         if (request()->wantsJson()) {
            return response($event, 201);
        }
        
        return redirect($event->path())->with('success', 'Event Updated Successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event,Trending $trending)
    {

        $trending->push($event);
        $events=Event::orderBy('created_at','desc')->paginate(8);
        $replies=$event->replies()->paginate(5);
        $related_events=Event::where('topic_id', '=', $event->topic->id)
            ->where('id', '!=', $event->id)
            ->paginate(4);
        $eventId=$event->id;
        $guests = User::whereHas('tickets', function ($q1) use ($eventId) {
    $q1->where('event_id', $eventId);
})->get();

         /*   $googleClient=new GuzzleClient();
            $response = $googleClient->get('https://maps.googleapis.com/maps/api/geocode/json',[
        'query'=>[
            'address'=>$event->location,
            'key'=>'AIzaSyAorsjtV7VJRlduybX8UoWYrD9SaRKWX7A'
            
        ]
    ]);
        $googleBody=json_decode($response->getBody());
        $coords=$googleBody->results[0]->geometry->location;*/
       
        return view('event.show',[
            'events'=>$events,
            'event'=>$event,
            'replies'=>$replies,
            'related_events'=>$related_events,
            'guests'=>$guests
            //'lng'=>$coords->lng,
            //'lat'=>$coords->lat 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
         $this->authorize('update', $event);
        $events=Event::orderBy('created_at','desc')->paginate(8);
        $topics = Topic::all();
        return view('event.edit',compact('event','topics','events'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
    $this->validate($request,[
    'name'=>'required',
    'desc'=>'required',
    'strtdt'=>'required',
    'strttm'=>'required',
    'endtm'=>'required',
    'location'=>'required',
    'price'=>'required',
    'venue'=>'required',
    'qty'=>'required',
    ]);
        
        
    $this->authorize('update', $event);
    $event->update(request(['name','desc','strtdt','enddt','strttm','endtm','location','price','qty','venue','topic_id']));
        
    if(!empty($request->image))
    {
    $user = Auth::user();
    $file = $request->file('image');
    $filename=uniqid($user->id."_").".".$file->getClientOriginalExtension();  
    Storage::disk('s3')->put($filename,File::get($file),'public');
    $image_path=Storage::disk('s3')->url($filename);
    $event->update(['image_path'=>$image_path]);
    }

        return redirect($event->path())->with('success', 'Event Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('update', $event);
        $event->delete();
    }
    
    public function delete(Event $event)
    {
        $this->authorize('update', $event);
        $event->forceDelete();
    }
    
     public function draftdelete($event)
    {
        $events=Event::withTrashed()->where('slug',$event)->first();
        $events->forceDelete();
    }

    public function undrafted($event)
    {
         $events=Event::withTrashed()->where('slug',$event)->first();
        $events->restore();
    }
    
}
