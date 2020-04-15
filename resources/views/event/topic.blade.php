@include('header')
      <header class="header" data-type="background" data-speed="7" style="background: linear-gradient(to right bottom, rgba(42, 43, 88, 0.4), rgba(42, 43, 88, 0.4)), url('https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80');
          background-size: cover;
                background-attachment: fixed;
  background-position:center;">
    <div class="header_bg">  
               <div class="header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">Explore {{$topic->name}}</span>
                 <span class="heading-primary_main">{{$topic->events->count()}} related events</span>
              </h1>
                   <p class="header-para"><b>Find out what's happening in {{$topic->name}} Meetup events around the world and start meeting up with the ones near you.</b></p>
         <a class="btn btn-info header-btn" href="/register">Sign Me Up</a>  
    </div>
        </div>
          
    </header>
<div class="container mt-5">
                  <p class="event-heading"><b>Events</b></p>
                  <div class="event-wrap">
            <div class="row">
          @if($topic->events->count() == 0)
          <div class="text-center">
          <h3>Sorry! No Event Found Of Related Topic</h3>
            </div>
          @else
           @foreach($topic->events as $event)
           @include('event.list') <!--import event list -->
            @endforeach
            @endif
         </div>
    </div>
</div>

    
@include('footer')
