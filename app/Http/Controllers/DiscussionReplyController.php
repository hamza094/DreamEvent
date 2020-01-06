<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use Auth;
use App\Event;
use App\Rules\SpamFree;
use App\Http\Forms\CreateEventForm;
use App\DiscussionReply;

class DiscussionReplyController extends Controller
{
    public function store(Reply $reply,Request $request){
           $this->validate($request,[
           'replybody'=>'required',
           ]);
        $reply->addDiscussionReply([
            'replybody'=>request('replybody'),
            'user_id'=>auth()->id()
        ]);
    }
    
     public function update(DiscussionReply $discussionreply,Request $request)
    {
        $this->validate($request,[
           'replybody'=>'required',
           ]);
        $discussionreply->update(request(['replybody']));
        
    }
    
      public function destroy(DiscussionReply $discussionreply){
        $discussionreply->delete();
        if (request()->wantsJson()) {
            return response(['status'=>'Discussion Reply deleted']);
        }

        return back();
    }
}
