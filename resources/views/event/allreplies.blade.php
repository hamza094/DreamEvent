  <modal class="" v-cloak id="reply-modal"  name="replyall{{$reply->id}}"
        height="auto"
         width="80%"
         transition="ease"
         scrollable>
         <div class="discussion-replies">
             <p class="discussion-replies_main">{!! str_limit($reply->body,200) !!}
              <span class="discussion-replies_text">
              (This Discussion Contains {{$reply->discussionreplies->count()}} Replies)
              </span> 
              </p>
   @foreach($reply->discussionreplies as $reply)
        <discussionreply :reply="{{$reply}}" :user="{{$reply->user}}"></discussionreply>
      <hr>
    @endforeach
             </div>
     </modal>