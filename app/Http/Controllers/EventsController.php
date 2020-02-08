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
use App\Notifications\ThreadHasUpdated;
use GuzzleHttp\Client as GuzzleClient;


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
    
    public function allevents(){
        if(request('drafted')) {
            return Event::onlyTrashed()->orderBy('created_at','desc')->with('user')->paginate(100);
        }elseif(request('live')){
            return Event::orderBy('created_at','desc')->with('user')->paginate(100); 
          }else{
            return Event::withTrashed()->orderBy('created_at','desc')->with('user')->paginate(15); 
         }
    }
    
    public function eventscount(){
        return Event::withTrashed()->get(); 
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
    
    public function admineventsearch(){
           if ($search = \Request::get('q')) {
            $events = Event::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->withTrashed()->with('user')->paginate(16);
        }else{
               $events= Event::withTrashed()->orderBy('created_at','desc')->with('user')->paginate(15); 
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
        $replies=$event->replies()->paginate(config('dream.pagination.perPage'));
        $related_events=Event::where('topic_id', '=', $event->topic->id)
            ->where('id', '!=', $event->id)
            ->paginate(4);
        $eventId=$event->id;
        
        //Event bought ticket users
        $guests = User::whereHas('tickets', function ($q1) use ($eventId) {
    $q1->where('event_id', $eventId);
})->get();
             
        //google geocode map
            $googleClient=new GuzzleClient();
            $response = $googleClient->get('https://maps.googleapis.com/maps/api/geocode/json',[
        'query'=>[
            'address'=>$event->location,
            'key'=>'AIzaSyAorsjtV7VJRlduybX8UoWYrD9SaRKWX7A'
            
        ]
    ]);
        $googleBody=json_decode($response->getBody());
        $coords=$googleBody->results[0]->geometry->location;
       
        return view('event.show',[
            'events'=>$events,
            'event'=>$event,
            'replies'=>$replies,
            'related_events'=>$related_events,
            'guests'=>$guests,
            'lng'=>$coords->lng,
            'lat'=>$coords->lat 
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
        
        //send notification on event update
         foreach($event->followers as $follower){
        if ($follower->user_id != $event->user_id) {
            $follower->user->notify(new ThreadHasUpdated($event));
        }
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
        $event->topic->decrement('events_count');

    }
    
    //draft event delete
     public function draftdelete($event)
    {
        $events=Event::withTrashed()->where('slug',$event)->first();
        $events->forceDelete();
        $event->topic->decrement('events_count');

    }

    public function undrafted($event)
    {
        $events=Event::withTrashed()->where('slug',$event)->first();
        $events->restore();
    }
    
}
