@include('header')
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    

<div class="container">
   <div class="calender mt-5">
   <h2 class="text-center mb-5">View Event Schedule</h2>
   <div class="mb-5">
       {!! $calender_details->calendar() !!}

{!! $calender_details->script() !!} 
   </div>

   </div>


</div>


</div>
</body>
</html>