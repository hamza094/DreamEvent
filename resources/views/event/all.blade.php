@include('header')
   <header class="main-header" data-type="background" data-speed="7">
    <div class="header_bg">  
               <div class="main-header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">View All Events</span>
              </h1>
              <p class="header-para">Join a local group to meet people, try something new, or do more of what you love</p>
         <a class="btn btn-info header-btn" href="/create-event">Create An Event</a>  
            <br><br><br>
             
    </div>
       
        </div>
          
    </header>
    <div class="container mt-5" id="app">           
        <p class="event-heading"><b>All Events</b></p>
       <events></events>

    </div>
@include('footer')
