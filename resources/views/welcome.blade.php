@include('header')
   <header class="main-header" data-type="background" data-speed="7">
    <div class="header_bg">  
               <div class="main-header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">The Real world is calling</span>
              </h1>
              <p class="header-para">Join a local group to meet people, try something new, or do more of what you love</p>
         <a class="btn btn-info header-btn" href="/create-event">Create An Event</a>  
            <br><br><br>
             
    </div>
       
        </div>
          
    </header>
    <div class="container mt-5">           
        <p class="event-heading"><b>Trending Events</b></p>
        <div class="row">
            <div class="col-md-3">
             <div class="tranding-event">
              <div class="event">
               <a href="/event/thomas-martha-save-city">
                <div class="event-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRHgpBZ4vy6nqlNxC1wMvs3Lxra86FM5K7Vgf0WtXu9v9JYzLGn" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> 4 jun,</span><span> 1:00 am</span></p>
                    </div>
                    <p class="event-name">Thomas Martha Save City</p>
                    <p class="event-location">Gothan Wyne Tower,Us</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
                  <div class="col-md-3">
             <div class="tranding-event">
              <div class="event">
               <a href="/event/thomas-martha-save-city">
                <div class="event-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRHgpBZ4vy6nqlNxC1wMvs3Lxra86FM5K7Vgf0WtXu9v9JYzLGn" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> 4 jun,</span><span> 1:00 am</span></p>
                    </div>
                    <p class="event-name">Thomas Martha Save City</p>
                    <p class="event-location">Gothan Wyne Tower,Us</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
                  <div class="col-md-3">
             <div class="tranding-event">
              <div class="event">
               <a href="/event/thomas-martha-save-city">
                <div class="event-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRHgpBZ4vy6nqlNxC1wMvs3Lxra86FM5K7Vgf0WtXu9v9JYzLGn" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> 4 jun,</span><span> 1:00 am</span></p>
                    </div>
                    <p class="event-name">Thomas Martha Save City</p>
                    <p class="event-location">Gothan Wyne Tower,Us</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
                  <div class="col-md-3">
             <div class="tranding-event">
              <div class="event">
               <a href="/event/thomas-martha-save-city">
                <div class="event-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRHgpBZ4vy6nqlNxC1wMvs3Lxra86FM5K7Vgf0WtXu9v9JYzLGn" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> 4 jun,</span><span> 1:00 am</span></p>
                    </div>
                    <p class="event-name">Thomas Martha Save City</p>
                    <p class="event-location">Gothan Wyne Tower,Us</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
         </div>
                 
                 
                  <p class="event-heading"><b>Events</b></p>
        <div class="row">
           @foreach($events as $event)
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
    <div class="text-center">
        <a href="/events" class="btn event-btn">Show All Events >></a>
    </div>
                   
        <p class="event-heading"><b>Topics</b></p>
        <p class="">Browse groups by topics you're interested in.</p>
        <div class="row">
        @foreach($topics as $topic)
      <div class="col-md-3">
              <div class="mb-5">
               <a href="topic/{{$topic->id}}">
                <div class="topic" style= "background-image: url('{{$topic->image}}'); background-position: center center;">
                   </div>
                   <div class="topic-name">{{$topic->name}}</div>
                </a>
          </div>
            </div>
            @endforeach
        </div>
    </div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati molestias, id magni iste praesentium perferendis quos saepe assumenda facilis quas architecto, quidem amet dolores animi eligendi, nostrum eveniet tenetur veritatis beatae voluptatem incidunt. Nesciunt fuga exercitationem enim itaque officiis maiores aut minima voluptatibus eaque, molestias dolorum nostrum obcaecati labore ipsam.</p>
@include('footer')
