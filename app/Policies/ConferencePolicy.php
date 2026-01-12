<?php

namespace App\Policies;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConferencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conference $conference): bool
    {
        return $conference->user_id === $user->id || $conference->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Conference $conference): bool
    {
        return $conference->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Conference $conference): bool
    {
        return $conference->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Conference $conference): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Conference $conference): bool
    {
        return false;
    }

    public function enable(User $user, Conference $conference): bool
    {
        return $conference->institution_id === $user->institution?->id || $conference->user_id === $user->id;
    }
}
