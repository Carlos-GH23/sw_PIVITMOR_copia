<?php

namespace App\Services;

use App\Enums\MatchAction;
use App\Models\CapabilityRequirementMatch;
use App\Models\MatchLog;
use App\Models\User;
use App\Traits\HasOrderableMoreRelations;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequirementMatchService
{
    use HasOrderableMoreRelations;
    protected $capabilityRequirementMatch;

    public function __construct(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->capabilityRequirementMatch = $capabilityRequirementMatch;
    }

    protected function getOrderableRelations(): array
    {
        return [
            'capability' => [
                'relations' => ['capability'],
                'order_column' => 'title',
            ],
            'requirement' => [
                'relations' => ['requirement'],
                'order_column' => 'title',
            ],
            // 'institution' => [
            //     'relations' => ['capability', 'user', 'academic', 'department', 'institution'],
            //     'order_column' => 'name',
            // ],
            'status' => [
                'relations' => ['matchStatus'],
                'order_column' => 'name',
            ],
        ];
    }

    public function queryCapability(object $filters, array $relations = [])
    {
        $user = Auth::user();

        $query = $this->buildQuery($filters, $relations);

        if ($user->canPermission('capabilities.viewInstitution')) {
            return $query->whereHas('capability', fn($q) => $q->fromInstitution($user->institution->id));
        }

        return $query->whereHas('capability', fn($q) => $q->where('user_id', $user->id));
    }

    public function queryRequirement(object $filters, array $relations = [])
    {
        $user = Auth::user();

        $query = $this->buildQuery($filters, $relations);

        if ($user->canPermission('requirements.viewInstitution')) {
            return $query->whereHas('requirement', fn($q) => $q->fromInstitution($user->institution->id));
        }

        return $query->whereHas('requirement', fn($q) => $q->where('user_id', $user->id));
    }

    public function buildQuery(object $filters, array $relations = [])
    {
        $query = CapabilityRequirementMatch::query()->with($relations)
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('compatibility_score', 'LIKE', "%{$search}%")
                        ->orWhereHas('requirement', fn($q) => $q->where('title', 'LIKE', "%{$search}%"))
                        ->orWhereHas('capability', fn($q) => $q->where('title', 'LIKE', "%{$search}%"));;
                });
            });
        return $query;
    }

    public function buildFilters($query, $filters)
    {
        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function accept(CapabilityRequirementMatch $match)
    {
        return DB::transaction(function () use ($match) {
            $this->handleAction($match, true);
        });
    }

    public function reject(CapabilityRequirementMatch $match)
    {
        return DB::transaction(function () use ($match) {
            $this->handleAction($match, false);
        });
    }

    private function handleAction(CapabilityRequirementMatch $match, bool $isAccepted)
    {
        $user = Auth::user();
        $actor = $this->resolveActor($match, $user);
        if (! $actor) return;

        $action = MatchAction::fromActorAndDecision($actor, $isAccepted);

        $match->update(['match_status_id' => $action->statusId()]);

        MatchLog::create([
            'capability_requirement_match_id' => $match->id,
            'user_id' => $user->id,
            'action' => $action,
            'description' => $action->description(),
        ]);
    }

    private function resolveActor(CapabilityRequirementMatch $match, User $user): ?string
    {
        return match (true) {
            $match->isOfferer($user) => 'offerer',
            $match->isApplicant($user) => 'applicant',
            default => null,
        };
    }
}
