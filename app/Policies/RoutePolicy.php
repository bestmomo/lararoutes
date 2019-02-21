<?php

namespace App\Policies;

use App\User;
use App\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoutePolicy
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

    /**
     * Determine if the given route can be managed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $route
     * @return bool
     */
    public function manage(User $user, Route $route)
    {
        return $user->id == $route->user_id;
    }
}
