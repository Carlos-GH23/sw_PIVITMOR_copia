<?php

namespace App\Policies;

use App\Models\Capability;
use App\Models\User;

class CapabilityPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Capability $capability): bool
    {
        return $capability->user_id === $user->id || $capability->institution_id === $user->institution?->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Capability $capability): bool
    {
        return $capability->user_id === $user->id && ($capability->capability_status_id === 1 ||
            $capability->capability_status_id === 4);
    }

    public function delete(User $user, Capability $capability): bool
    {
        return $capability->user_id === $user->id && $capability->capability_status_id !== 2;
    }

    public function enable(User $user, Capability $capability): bool
    {
        return $capability->institution_id === $user->institution?->id;
    }

    public function validity(User $user, Capability $capability): bool
    {
        return $capability->user_id === $user->id && $capability->capability_status_id === 6;
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
