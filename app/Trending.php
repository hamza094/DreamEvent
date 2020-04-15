<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Trending
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 3));
    }

    //push trending events
    public function push($event)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'name'=>$event->name,
            'path'=>$event->path(),
            'img'=>$event->image_path,
            'loc'=>$event->location,
            'strtdt'=>$event->startdate,
            'strttm'=>$event->strttm
        ]));
    }

    public function cacheKey()
    {
        return app()->environment('testing') ? 'testing_high_events' : 'high_events';
    }
}