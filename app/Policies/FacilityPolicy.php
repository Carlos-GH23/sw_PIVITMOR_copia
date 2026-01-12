<?php

namespace App\Policies;

use App\Models\Institution\Facility;
use App\Models\Institution\Institution;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FacilityPolicy
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
    public function view(User $user, Facility $facility): bool
    {
        return $facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
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
    public function update(User $user, Facility $facility): bool
    {
        return $facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Facility $facility): bool
    {
        return $facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Facility $facility): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Facility $facility): bool
    {
        return false;
    }

    /**
     * Determine whether the user can enable/disable the model.
     */
    public function enable(User $user, Facility $facility): bool
    {
        return $facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }
}
