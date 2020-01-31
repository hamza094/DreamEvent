@include('header')
<script src="https://checkout.stripe.com/checkout.js"></script>
@include('event.map')
<div class="container">
    <div class="single-event">
        <div class="row">
            <div class="col-md-7">
                <div id="app">

                    <!--Event Left Side Start-->
                    <div class="single-event_left">
                        <img src="{{$event->image_path}}" alt="">
                        <div class="single-event_detail">

                            <!--Event Follow Button-->
                            <event-follow :active="{{json_encode($event->isFollowedTo)}}"></event-follow>
                            <p class="single-event_detail-desc">{!! $event->desc !!}</p>
                        </div>

                        <!--Event Reply Form-->
                        @if(Auth::user())
                        <reply-form :event="{{$event}}"></reply-form>
                        @endif
                        <h4 class="text-center mt-3">Discussions</h4>

                        <!-- All Event Discussion-->
                        @foreach ($replies as $reply)
                        <reply inline-template :reply="{{$reply}}">
                            <div id="reply-{{$reply->id}}">
                                <div class="single-event_replies">

                                    <p><a href="/profile/{{$reply->user->id}}">
                             <img src="{{$reply->user->avatar_path}}" alt="">
                                        <b>{{$reply->user->name}}</b></a> Replied</p>
                                    <p class="mt-2"><b v-text="body"></b></p>
                                    <p>
                                        @can('update',$reply)
                                        <span class="span-left"><button class="btn btn-sm btn-primary" @click.prevent="show">Edit</button> <button class="btn btn-sm btn-danger" @click.prevent="destroy">Delete</button></span> @endcan
                                        <span class="float-right">Replied at:<b>{{$reply->created_at->diffForHumans()}}</b></span></p>

                                    <!--Event Discussion Reply-->
                                    @if(Auth::user())
                                    <p class="mb-3"> <span class="float-left btn btn-link" @click="$modal.show('reply{{$reply->id}}')">Reply</span>
                                    @endif
                                    @if($reply->discussionreplies->count()>0)
                                    <span class="float-left btn btn-link" @click="$modal.show('replyall{{$reply->id}}')">View All Replies</span> 
                                    @endif
                                    </p>
                                </div>
                                <div>
                                    @include('event.modal')
                                    @include('event.reply')
                                </div>
                            </div>
                        </reply>
                        @include('event.allreplies')
                        @endforeach
                    </div>
                </div>
                {!! $replies->render() !!}
            </div>
            <div class="col-md-5">
                <!-- Event Right Side-->
                <div class="single-event_right mb-3" id="show">
                    <div class="single-event_main-info">
                        <p>
                            @if($event->strtdt > \Carbon\Carbon::now()->toDateTimeString())
                            <span class="badge badge-success">{{$event->strtdt->diffforHumans()}}</span> @else
                            <span class="badge badge-danger">{{$event->strtdt->diffforHumans()}}</span> @endif @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span></span> @else @if($event->qty!=0)
                            <span class="badge badge-success">Tickets Available</span> @else
                            <span class="badge badge-danger">Tickets Not Available</span> @endif @endif @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span class="badge badge-danger">Event Closed</span> @else
                            <span class="badge badge-success">Event Open</span> @endif

                        </p>
                        <p class="single-event_name">{{$event->name}}</p>
                        <p class="single-event_price mt-3">Price: ${{$event->price}}</p>
                    </div>
                    <div class="mt-4">
                        <h5><b>Date and time</b></h5>
                        <p><i class="far fa-calendar-alt"></i> <b>{{$event->startdate}} to {{$event->enddate}}</b></p>
                        <p><i class="far fa-clock"></i> <b>{{$event->strttm}} - {{$event->endtm}} PKST</b></p>
                        <p><i class="fas fa-map-marker-alt"></i><span><b> {{$event->location}}</b></span>
                            <span><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> <b>More Info</b> <i class="far fa-arrow-alt-circle-down"></i></a></span>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                @if($event->venue!=null)
                                <b>{{$event->venue}}</b> @else
                                <b>Sorry! No more information available</b> @endif
                            </div>
                        </div>
                        <!--Event Ticket Option-->
                        @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                        <p></p>
                        @else
                        @if(Auth::user())
                        <ticket-form :event="{{$event}}"></ticket-form>
                        @else
                        <p><a href="/login" class="btn event-btn float-right">Buy Ticket</a></p>
                        @endif

                        <!-- Event Add to calender-->
                        <p>
                            <div title="Add to Calendar" class="addeventatc">
                                Add to Calendar
                                <span class="start">{{$event->strtdt}} {{$event->strttm}}</span>
                                <span class="end">{{$event->enddt}} {{$event->endtm}}</span>
                                <span class="timezone">Pakistan/Islamabad</span>
                                <span class="title">{{$event->name}}</span>
                                <span class="description">{{$event->desc}}</span>
                                <span class="location">{{$event->location}}</span>
                            </div>
                        </p>
                        @endif
                    </div>
                    <div class="mt-4 single-event_organize">
                        <h5><b>Organizer</b></h5>
                        <p><a href="/profile/{{$event->user->id}}"><span><img src="{{$event->user->avatar_path}}" alt=""></span><span> <b>{{$event->user->name}}</b></span></a> 
                        @if(Auth::user())
                        <span class="float-right">
                        <contact-form :event="{{$event}}"></contact-form>
                        </span> 
                        @endif
                        </p>
                    </div>

                    @if($guests->count()>0)
                    <button class="btn btn-primary btn-sm" @click="$modal.show('guestModal')">View Event Guests</button> @include('event.guest') 
                    @endif
                </div>
                <div id="map"></div>
                <div class="sharethis-inline-share-buttons mt-3"></div>
            </div>
        </div>
    </div>
    <div class="topic-events mt-5">

        <!-- Related Events-->
        <h3 class="text-cente mb-5">Related Events</h3>
        <div class="row">
            @foreach($related_events as $event)
            <div class="col-md-3 text-center">
                <div class="event-panel">
                    <div class="event">
                        <a href="{{$event->path()}}">
                            <div class="event-img">
                                <img src="{{$event->image_path}}" alt="">
                            </div>
                            <div class="event-text">
                                <div class="event-time">
                                    <p><i class="far fa-clock"></i><span> {{$event->startdate}},</span><span> {{$event->strttm}}</span></p>
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
    </div>
</div>
@include('footer')