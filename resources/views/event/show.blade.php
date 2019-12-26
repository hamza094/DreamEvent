@include('header')

 
   <div class="container">
                <div class="single-event">
       <div class="row">
           <div class="col-md-7">
             <div class="" id="app">
              <div class="single-event_left">
                <img src="{{$event->image_path}}" alt="">                  
              
              <div class="single-event_detail">
                 <p class="single-event_detail-heading">About this event <span><a href="" class="btn header-btn float-right">Follow Event</a></span> </p>
                  <p class="single-event_detail-desc">{{$event->desc}}</p>
              </div>
              
                  <h5>Discussion</h5>
                  @if(Auth::user())
                  <reply-form :event="{{$event}}"></reply-form>
                  <ticket-form inline-template :event="{{$event}}">
                <div>
                <p><button  class="btn event-btn float-right"  @click="$modal.show('ticketModal')">Attend Event</button></p>
                   @include('event.ticket')
                  </div>
                </ticket-form>
              @endif
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
              </div>
                   <div>
 @include('event.modal')
 </div>
          </div>
              </reply>
@endforeach
             
              
              
              
           </div>
               </div>
               {!! $replies->render() !!}
            </div>
           <div class="col-md-5">
               <div class="single-event_right mb-3">
                   <div class="single-event_main-info">
                       <p class="badge badge-success">{{$event->strtdt}}</p>
                       <p class="single-event_name">{{$event->name}}</p>
                        <p class="single-event_price mt-3">Price: ${{$event->price}}</p>
                   </div>
                      <div class="mt-4">
                          <h5><b>Date and time</b></h5>
                          <p><i class="far fa-calendar-alt"></i> <b>{{$event->strtdt}} to {{$event->enddt}}</b></p>
                          <p><i class="far fa-clock"></i> <b>{{$event->strttm}} - {{$event->endtm}} PKM</b></p>
                          <p><i class="fas fa-map-marker-alt"></i><span> <b> {{$event->location}}</span><span> {{$event->venue}}</span></span></p>
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
                       <p><a href="/profile/{{$event->user->id}}"><span><img src="{{$event->user->avatar_path}}" alt=""></span><span> {{$event->user->name}}</span></a></p>
                   </div>
                 </div>
                           <div class="sharethis-inline-share-buttons mt-3"></div>

           </div>   
          </div>
       </div>
       <div class="topic-events mt-5">
           <h3 class="text-cente mb-5">Related Events</h3>
           <div class="row">
           @foreach($related_events as $event)
                   <div class="col-md-3">
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