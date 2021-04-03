<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    // Determine if the user profile can be updated by the user
    public function update(User $user, User $user_model)
    {
        return $user->id === $user_model->id;
    }
}
