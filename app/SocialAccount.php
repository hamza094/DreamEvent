<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongs('App\User');
    }
}
