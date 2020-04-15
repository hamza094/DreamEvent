@include('header')
        <div id="show"></div>
         <div id="app">
          <edit-profile :user="{{$user}}"></edit-profile>
      <header class="header" data-type="background" data-speed="7" style="background: linear-gradient(to right bottom, rgba(42, 43, 88, 0.9), rgba(42, 43, 88, 0.9)), url('{{$user->backimg}}');
          background-size: cover;
                background-attachment: fixed;
  background-position:center;">
    <div class="header_bg">  
               <div class="header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">Welcome </span>
                <span class="heading-primary_main">{{$user->name}}</span>
              </h1>
              <p class="header-para">This is your profile page. You can see the progress you've made 
              with your work and manage your projects or assigned tasks</p>
              @can('update', $user)
         <button class="btn btn-info header-btn" @click="$modal.show('EditProfile')">Edit Profile</button>  
         @endcan
    </div>
        </div>
    </header>
    <div class="container">
        <div class="row mt-5">
                       <div class="col-md-4">
                <div class="user-profile">
                 <avatar-form :user="{{$user}}"></avatar-form>
                <div class="row user-profile_info">
                        <div class="col-sm-4"><span><b>{{$user->events->count()}}</b></span><br><span>Events</span></div>
                        <div class="col-sm-4"><span><b>{{$user->replies->count()}}</b></span><br><span>Comments</span></div>
                        <div class="col-sm-4"><span><b>{{$user->tickets->sum('qty')}}</b></span><br><span>Tickets</span></div>
                    </div>
                    <p><h5>{{$user->name}}</h5></p>
                    <p>{{$user->email}}</p>
                    <p>{{$user->created_at->diffforHumans()}}</p>
                </div>
            </div>
            
            <div class="col-md-8">
              <div class="profile-activity">
               <h3>Activity feed</h3>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis aut cupiditate fugit deleniti voluptatem, fugiat, architecto tempore nesciunt! Id distinctio nam quod atque voluptatum ipsam error odio, tempore similique alias quia eaque, aspernatur unde ipsum earum incidunt sunt laborum blanditiis magni doloribus molestias. Esse, dolor, accusamus. Nostrum nulla exercitationem veritatis eum iure atque eaque blanditiis, animi quas magni! Placeat ratione facilis at totam blanditiis, reiciendis tempore nihil perspiciatis, dolorem pariatur ad corporis accusantium impedit distinctio ab consequuntur libero nisi laudantium vitae aliquid, enim quam quos molestiae. Velit recusandae aperiam eligendi cupiditate hic vitae quis ullam, itaque suscipit. Eligendi deleniti, repudiandae.
              <div class="event-ticket">
                <p class="event-ticket_heading">You are Member of these events</p>
                <div class="row">
                @if($user->tickets->count()==0)
                    <h3 class="text-center mb-4 ml-2">Sorry! No Event Found</h3>
                    <h3 class="text-center mb-3 ml-2"><i><a href="/events">Haven't Decided to join any event view all events</a></i></h3>
                @else
                @foreach($user->tickets as $ticket)
                <div class="col-lg-6 col-md-12">
                    <a href="/events/{{$ticket->event->slug}}" target="_blank">
                    <div class="event-ticket_single">
                      <div class="row">
                    <div class="col-sm-3">
                        <img src="{{$ticket->event->image_path}}" alt="" class="event-ticket_img">
                        @if($ticket->event->enddt > \Carbon\Carbon::now()->toDateTimeString())
                      <span class="badge badge-success">{{$ticket->event->strtdt->diffforHumans()}}</span>
                    @else
                    <span class="badge badge-danger">{{$ticket->event->strtdt->diffforHumans()}}</span>
                    @endif
                        <p><b>Qty:{{$ticket->qty}}</b></p>
                        <p><b>Amount:${{$ticket->total}}</b></p>
                    </div>
                    <div class="col-sm-9">
                       <div class="event-ticket_single-detail">
                        <p class="event-ticket_single-name">{!!substr(strip_tags($ticket->event->name), 0, 28)!!}</p>
                           <p><b>Start At:{{$ticket->event->StartDate}}</b></p>
                           <p><b>Purchsed At:{{$ticket->created_at}}</b></p>

                        </div>
                    </div>
                </div>
                </div>
             </a>
                </div>
                
         @endforeach 
        @endif         
                  </div>
              </div>
            </div>
        </div>
             </div>
    </div>
@include('footer')
