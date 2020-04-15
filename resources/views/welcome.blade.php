@include('header')
  <!-- Header-->
   <header class="main-header" data-type="background" data-speed="7">
    <div class="header_bg">  
               <div class="main-header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">The Real world is calling</span>
              </h1>
              <p class="header-para">Join a local group to meet people, try something new, or do more of what you love</p>
            <a class="btn btn-info header-btn" href="/fullcalender">Event Calender</a>  
              <a class="btn btn-info header-btn" href="/events/create">Create An Event</a>
            <br><br><br>
             
    </div>
       
        </div>
          
    </header>
    <div id="show"></div>
    <div class="container mt-5" id="app">
       <!-- Tranding-->                     
        <p class="event-heading"><b>Trending Events</b></p>
        <div class="event-wrap">
         <div class="row">
           @foreach($trending as $event)
            <div class="col-lg-3 col-md-4 col-sm-6 text-center">
             <div class="event-panel">
              <div class="event">
               <a href="{{$event->path}}">
                <div class="event-img">
                        <img src="{{$event->img}}" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span>{{$event->strtdt}} ,</span><span>{{$event->strttm}} </span></p>
                    </div>
                    <p class="event-name">{{$event->name}}</p>
                    <p class="event-location">{{$event->loc}}</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
             @endforeach
         </div>
        </div>         
                 <!-- All Events-->
                  <p class="event-heading mt-5"><b>Events</b></p>
                  <div class="event-wrap">
            <div class="row">
           @foreach($events as $event)
           @include('event.list') <!--import event list -->
            @endforeach
         </div>
        </div>
    <div class="text-center">
        <a href="/events" class="btn event-btn">Show All Events >></a>
    </div>
                   <!-- All Topics-->
        <p class="event-heading"><b>Topics</b></p>
        <p><b>Browse groups by topics you're interested in.</b></p>
        <div class="event-wrap">
        <div class="row">
        @foreach($topics as $topic)
      <div class="col-lg-3 col-md-4 col-sm-6 text-center">
              <div class="mb-5">
               <a href="topic/{{$topic->slug}}">
                <div class="topic" style= "background-image: url('{{$topic->image}}'); background-position: center center;">
                   </div>
                   <div class="topic-name">{{$topic->name}}</div>
                </a>
          </div>
            </div>
            @endforeach
        </div>
        </div>
            <subscribe></subscribe>
            </div>
@include('footer')
