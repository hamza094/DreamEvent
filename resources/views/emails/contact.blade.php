<html>
    <head>
        <title>
            DreamEvent 
        </title>
        <style>
            h3{
                text-align: center;
            }
                .span{
                 text-transform: capitalize;   
                }
            h4{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h3>You have a new Message From DreamEvent</h3>
        <p>{{$name}} Sent you message from your event <a href="http://localhost:8000/events/{{$eventSlug}}"> {{$eventName}}</a></p>
        <hr>
        <h4>Subject: <span class="span">{{$subject}}</span></h4>
        <p>{{$body}}</p>
    </body>
</html>
