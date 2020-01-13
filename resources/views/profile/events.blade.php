@include('header')
<div id="app">
    <div class="container">
       <div class="event-option">
       <span class="event-option_btn">
          <a href="/myevents" class="btn {{ Route::is('myevents') && empty(Request::query()) ? 'btn-primary' : 'btn-secondary' }}">Live Events</a>
          <a href="/myevents?drafted=1" class="btn {{ request()->has('drafted') ? 'btn-primary' : 'btn-secondary' }}">Drafted Events</a>
        </span>
        <a href="events/create" class="btn event-btn float-right">+ Create New Event</a>
        </div>
         @if (Route::is('myevents') && empty(Request::query()))
            <p class="event-heading mt-5"><b>Your Live Events</b></p>
            @elseif(request()->has('drafted'))
        <p class="event-heading mt-5"><b>Your Drafted Events</b></p>
        @endif
        <div class="row">
          @if($events->count() == 0)
          <div class="event-null">
          <img src="{{asset('img/event.jpg')}}" alt="">
          <p>No events to show</p>
          </div>
          @endif
           @foreach($events as $event)
            <div class="col-md-3 text-center">
             <div class="event-panel">
              <div class="event">
               <a href="{{$event->path()}}">
                <div class="event-img">
                        <img src="{{$event->image_path}}" alt="">
                    </div>
                    @can('update',$event)
                     <event-option :event="{{$event}}"></event-option>
                     @endcan
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> {{$event->strtdt}},</span><span> {{$event->strttm}}</span></p>
                    </div>
                    <p class="event-name">{{$event->name}}</p>
                    <p class="event-location">{{$event->location}}</p>
                    <p>
                    </p>
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
