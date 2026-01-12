<?php

namespace App\Policies;

use App\Models\TechnologyService;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TechnologyServiceEvaluationPolicy
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
    public function view(User $user, TechnologyService $technologyService): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, TechnologyService $technologyService): bool
    {
        return $technologyService->technology_service_status_id === 2 && $technologyService->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }
}
