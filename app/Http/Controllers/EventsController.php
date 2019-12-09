<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

use App\Rules\Recaptcha;

use Illuminate\Validation\Rule;
use Auth;
use Spatie\Searchable\Search;
use Session;
use App\Topics;
use Validator;
use Storage;
use File;
use Image;


class EventsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }
   
    
    public function index(Request $request)
    {
        $results = (new Search())
    ->registerModel(Event::class, ['name'])
    ->search($request->input('query'));
    
    return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $topics = Topics::all();
        return view('event.create',compact('topics'))->with('status', 'Profile updated!');
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
           'created_by'=>auth()->id(),
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
        
        return redirect()->back()->with('success', 'Event Created Successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
