<?php

namespace App\Policies;

use App\Models\Requirement;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RequirementPolicy
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
    public function view(User $user, Requirement $requirement): bool
    {
        return $requirement->user_id === $user->id || $requirement->institution_id === $user->institution?->id;
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
    public function update(User $user, Requirement $requirement): bool
    {
        return $user->id === $requirement->user_id && ($requirement->requirement_status_id === 1 || $requirement->requirement_status_id === 4); // status 1 = borrador 4 = rechazado con observaciones
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Requirement $requirement): bool
    {
        return $user->id === $requirement->user_id && $requirement->requirement_status_id !== 2; // enviado a validar
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Requirement $requirement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Requirement $requirement): bool
    {
        return false;
    }

    public function evaluation(User $user, Requirement $requirement): bool
    {
        return $requirement->requirement_status_id === 2 && $requirement->institution_id === $user->institution?->id; // status 2 = enviado a validar
    }

    public function enable(User $user, Requirement $requirement): bool
    {
        return $user->id === $requirement->user_id || $requirement->institution_id === $user->institution?->id;
    }

    public function validity(User $user, Requirement $requirement): bool
    {
        return $requirement->user_id === $user->id && $requirement->requirement_status_id === 6; // status 6 = cerrado
    }
}
