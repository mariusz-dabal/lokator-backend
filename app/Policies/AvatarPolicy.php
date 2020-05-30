<?php

namespace App\Policies;

use App\Avatar;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvatarPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasAnyRole('Admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Avatar  $avatar
     * @return mixed
     */
    public function view(User $user, Avatar $avatar)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Avatar  $avatar
     * @return mixed
     */
    public function update(User $user, Avatar $avatar)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Avatar  $avatar
     * @return mixed
     */
    public function delete(User $user, Avatar $avatar)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Avatar  $avatar
     * @return mixed
     */
    public function restore(User $user, Avatar $avatar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Avatar  $avatar
     * @return mixed
     */
    public function forceDelete(User $user, Avatar $avatar)
    {
        //
    }
}
