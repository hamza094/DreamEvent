<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use Auth;
use App\Event;
use App\Rules\SpamFree;
use App\Http\Forms\CreateEventForm;

class ReplyController extends Controller
{
    
    public function __construct()
    {
      $this->middleware('auth');   
    }
    
    public function index(){
        
    }
    
    public function store(Request $request,Event $event,CreateEventForm $form){
          $this->validate($request,[
           'body'=>'required|spamerror',
           ]);
        $event->addReply([
            'body'=>request('body'),
            'user_id'=>auth()->id()
        ]);
        
        if(request()->wantsJson()){
            return ['message'=>$event->path()];
        }
        
        return back();
    }
    
    public function update(Reply $reply)
    {
         $this->authorize('update', $reply);
        $this->validate(request(), ['body'=>'required|spamerror']);
        $reply->update(request(['body']));
        
    }
    
    public function destroy(Reply $reply){
           $this->authorize('update', $reply);
        $reply->delete();
        if (request()->wantsJson()) {
            return response(['status'=>'Reply deleted']);
        }

        return back();
    }
}
