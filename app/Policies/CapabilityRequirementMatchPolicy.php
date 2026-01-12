<?php

namespace App\Policies;

use App\Models\CapabilityRequirementMatch;
use App\Models\MatchEvaluation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class CapabilityRequirementMatchPolicy
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
    public function view(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return true;
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
    public function update(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return true;
    }

    public function matchRequirement(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return $user->id === $capabilityRequirementMatch->requirement->user_id && $capabilityRequirementMatch->match_status_id === 1;
    }

    public function matchCapability(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return $user->id === $capabilityRequirementMatch->capability->user_id && $capabilityRequirementMatch->match_status_id === 2;
    }

    public function createMatchEvaluation(User $user, CapabilityRequirementMatch $capabilityRequirementMatch): bool
    {
        return $capabilityRequirementMatch->match_status_id === 3 && (
            ($capabilityRequirementMatch->isOfferer($user) && $capabilityRequirementMatch->offererEvaluation === null) ||
            ($capabilityRequirementMatch->isApplicant($user) && $capabilityRequirementMatch->applicantEvaluation === null)
        );
    }
}
