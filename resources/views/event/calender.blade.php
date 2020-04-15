<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="{{asset('img/Dream.png')}}">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DreamEvent || Event Calendar</title>
    <!-- Scripts -->
          
        <script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
    
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                         
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @foreach($events as $event)
 <style>
     .event:before{
         position: absolute;
         content:"${{$event->price}}";
         top: 0;
         right:-35px;
         width:150px;
         height: 40px;
         line-height: 40px;
         text-align: center;
         transform: rotate(30deg);
         background-color:#2D395D ;
         color:#ffffff;
         
         
     }
</style>
 
 @endforeach
    </head>
    <body>
       <div id="">
          
           <div class="main-navbar" id="nav">
           <div class="main-logo">
               <a href="/"><img src="{{asset('img/logo.png')}}"></a>
           </div>
            </div>
    

<div class="container">
   <div class="calender mt-5">
   <h2 class="text-center mb-5">View Event Schedule</h2>
   <div class="mb-5">
       {!! $calender_details->calendar() !!}

{!! $calender_details->script() !!} 
   </div>

   </div>


</div>
<footer>
    <div class="container-fluid">
        <div class="row">
           <div class="footer">
              <div class="footer-content">
                 <p class="footer-content_para">
                   "DreamEvent is a Laravel Vue.js based Event Application built for portfolio purpose you can find its source code on <a href="https://github.com/hamza094/Dream" target="_blank">GitHub</a> repository built by <a href="https://hikportfolio.herokuapp.com/" target="_blank">Hamza Ikram</a> &copy; 2020 All Right Reserved!"
               </p>
               <div class="footer-content_contact">
                   <p class="footer-content_contact-para">Get In Contact</p>
                   <ul>
                    <li><a href="https://www.facebook.com/hamza.ikram.986" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://github.com/hamza094" target="_blank"><i class="fab fa-github"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/hamzaik/" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="mailto:hamza_pisces@live.com"><i class="far fa-paper-plane"></i></a>></li>
                   </ul>
               </div>  
              </div>
          </div>
    </div>
    </div>
</footer>

</div>
</body>
</html>