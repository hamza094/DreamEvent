<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function update(User $user, Event $event)
    {
         $user= $event->user_id == $user->id || $user->isAdmin();
        return $user;
    }
}
