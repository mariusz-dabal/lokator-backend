<?php

namespace App\Policies;

use App\Flat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Flat  $flat
     * @return mixed
     */
    public function view(User $user, Flat $flat)
    {
        return $flat->id === $user->flat_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Flat  $flat
     * @return mixed
     */
    public function update(User $user, Flat $flat)
    {
        return $flat->id === $user->flat_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Flat  $flat
     * @return mixed
     */
    public function delete(User $user, Flat $flat)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Flat  $flat
     * @return mixed
     */
    public function restore(User $user, Flat $flat)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Flat  $flat
     * @return mixed
     */
    public function forceDelete(User $user, Flat $flat)
    {
        //
    }
}
