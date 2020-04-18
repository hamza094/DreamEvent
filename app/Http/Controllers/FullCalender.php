<?php

namespace App\Http\Controllers;

use App\Event;

class FullCalender extends Controller
{
    public function view()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(8);
        $calenderevents = Event::get();
        $event_list = [];
        foreach ($calenderevents as $key=>$event) {
            $event_list[] = \Calendar::event(
           $event->name,
            true,
            new \DateTime($event->strtdt),
            new \DateTime($event->enddt.'+1 day'),
              0, [
                  'url' => "events/$event->slug"
              ]
           );
        }
        $eloquentEvent = Event::first();
        $calender_details = \Calendar::addEvents($event_list);

        return view('event.calender', compact('events', 'calender_details'));
    }
}
