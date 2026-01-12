<?php

namespace App\Policies;

use App\Models\Capability;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CapabilityEvaluationPolicy
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
    public function view(User $user, Capability $capability): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Capability $capability): bool
    {
        return $capability->capability_status_id === 2 && $capability->institution_id === $user->getInstitutionId();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Capability $capability): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Capability $capability): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Capability $capability): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Capability $capability): bool
    {
        return false;
    }
}
