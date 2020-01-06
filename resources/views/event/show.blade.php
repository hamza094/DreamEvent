@include('header')
<script src="https://checkout.stripe.com/checkout.js"></script>

 
   <div class="container">
                <div class="single-event">
       <div class="row" id="app">
           <div class="col-md-7">
             <div class="" >
              <div class="single-event_left">
                <img src="{{$event->image_path}}" alt="">                  
              
              <div class="single-event_detail">
                 <p class="single-event_detail-heading">About this event <span><a href="" class="btn header-btn float-right">Follow Event</a></span> </p>
                  <p class="single-event_detail-desc">{{$event->desc}}</p>
              </div>
            @if(Auth::user())
                  <reply-form :event="{{$event}}"></reply-form>
              @endif
                                       <h4 class="text-center mt-3">Discussions</h4>

                      @foreach ($replies as $reply)
      <reply inline-template :reply="{{$reply}}">
       <div>
        <div class="single-event_replies">
           
            <p><a href="/profile/{{$reply->user->id}}">
            <img src="{{$reply->user->avatar_path}}" alt="">
                {{$reply->user->name}}</a> Replied</p> 
            <p class="mt-2"><b v-text="body"></b></p>
              <p>
              @can('update',$reply)
              <span class="span-left"><button class="btn btn-sm btn-primary" @click.prevent="show">Edit</button> <button class="btn btn-sm btn-danger" @click.prevent="destroy">Delete</button></span>
              @endcan
              <span class="float-right">Replied at:<b>{{$reply->created_at->diffForHumans()}}</b></span></p>
              <p class="mb-3"> <span class="float-left btn btn-link"  @click="$modal.show('reply{{$reply->id}}')">Reply</span>
              @if($reply->discussionreplies->count()>0)
              <span class="float-left btn btn-link"  @click="$modal.show('replyall{{$reply->id}}')">View All Replies</span>
              @endif</p>
              </div>
                   <div>
 @include('event.modal')
 @include('event.reply')
 </div>
          </div>
              </reply>
               @include('event.allreplies')
@endforeach
             
              
              
              
           </div>
               </div>
               {!! $replies->render() !!}
            </div>
              <div class="col-md-5">
               <div class="single-event_right mb-3">
                   <div class="single-event_main-info">
                     <p>
                      <span class="badge badge-success">{{$event->strtdt}}</span>
                      @if($event->qty!=0)
                      <span class="badge badge-success">Tickets Available</span>
                      @else
                    <span class="badge badge-danger">Tickets Not Available</span>
                     @endif
                      </p>
                       <p class="single-event_name">{{$event->name}}</p>
                        <p class="single-event_price mt-3">Price: ${{$event->price}}</p>
                   </div>
                      <div class="mt-4">
                          <h5><b>Date and time</b></h5>
                          <p><i class="far fa-calendar-alt"></i> <b>{{$event->strtdt}} to {{$event->enddt}}</b></p>
                          <p><i class="far fa-clock"></i> <b>{{$event->strttm}} - {{$event->endtm}} PKM</b></p>
                          <p><i class="fas fa-map-marker-alt"></i><span> <b> {{$event->location}}</span><span> {{$event->venue}}</span></span></p>
                          <ticket-form :event="{{$event}}"></ticket-form>
                          <!--<div id="map"></div>-->
                        <p>           <div title="Add to Calendar" class="addeventatc">
    Add to Calendar
    <span class="start">{{$event->strtdt}} {{$event->strttm}}</span>
    <span class="end">{{$event->enddt}} {{$event->endtm}}</span>
    <span class="timezone">Pakistan/Islamabad</span>
    <span class="title">{{$event->name}}</span>
    <span class="description">{{$event->desc}}</span>
    <span class="location">{{$event->location}}</span>
</div></p>
                  
                   </div>
                   <div class="mt-4 single-event_organize">
                       <h5><b>Organizer</b></h5>
                       <p><a href="/profile/{{$event->user->id}}"><span><img src="{{$event->user->avatar_path}}" alt=""></span><span> {{$event->user->name}}</span></a>
                       <button class="btn btn-link">Contact Organizer</button>
                       </p>
                   </div>
                 </div>
                           <div class="sharethis-inline-share-buttons mt-3"></div>
                           @if($guests->count()>0)
           <button class="btn btn-link mt-3" @click="$modal.show('guestModal')"><h5>View All Event Guests</h5></button>
                  @include('event.guest')
                  @endif
           </div>   
          </div>
       </div>
       <div class="topic-events mt-5">
           <h3 class="text-cente mb-5">Related Events</h3>
           <div class="row">
           @foreach($related_events as $event)
                   <div class="col-md-3 text-center">
             <div class="event-panel">
              <div class="event">
               <a href="{{$event->path()}}">
                <div class="event-img">
                        <img src="{{$event->image_path}}" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> {{$event->strtdt}},</span><span> {{$event->strttm}}</span></p>
                    </div>
                    <p class="event-name">{{$event->name}}</p>
                    <p class="event-location">{{$event->location}}</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
           @endforeach
           </div>
       </div>
   </div>
   
    @include('footer')