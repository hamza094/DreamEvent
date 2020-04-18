<?php

namespace App\Policies;

use App\DiscussionReply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionRepliesPolicy
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

    public function permission(User $user, DiscussionReply $discussionreply)
    {
        return $discussionreply->user_id == $user->id;
    }
}
