@include('header')
   <div class="container">
                <div class="single-event">
       <div class="row">
           <div class="col-md-7">
              <div class="single-event_left">
                <img src="{{$event->image_path}}" alt="">                  
              
              <div class="single-event_detail">
                 <p class="single-event_detail-heading">About this event <span><a href="" class="btn header-btn float-right">Follow Event</a></span> </p>
                  <p class="single-event_detail-desc">{{$event->desc}}</p>
              </div>
              <div class="mt-5">
                  <h5>Discussion</h5>
              </div>
              </div>
           </div>
           <div class="col-md-5">
               <div class="single-event_right">
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
                   <div>
                        <p><a href="" class="btn event-btn">Attend Event</a></p>
                    </div>
                   <div class="mt-4 single-event_organize">
                       <h5><b>Organizer</b></h5>
                       <p><a href="/profile/{{$event->user->id}}"><span><img src="{{$event->user->avatar_path}}" alt=""></span><span> {{$event->user->name}}</span></a></p>
                   </div>
                 </div>
           </div>   
          </div>
           
       </div>
   </div>
    @include('footer')