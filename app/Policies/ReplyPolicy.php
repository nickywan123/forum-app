<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }


    public function create(User $user){
        //get the last reply
        $lastReply = $user->fresh()->lastReply;
        //check if there is reply by the user
        if(! $lastReply){
            return true;
        }
        // allow reply posted more than a minute
        return ! $lastReply->wasJustPublished();
    }
}
