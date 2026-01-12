<?php

namespace App\Models;

use App\DTOs\ReportFiltersDTO;
use App\Enums\MatchAction;
use App\Notifications\MatchNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CapabilityRequirementMatch extends Model
{
    protected $fillable = [
        'compatibility_score',
        'matching_algorithm',
        'is_active',

        'requirement_id',
        'capability_id',
        'match_status_id',
    ];

    protected $casts = [
        'compatibility_score' => 'float',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($capabilityRequirementMatch) {
            if (is_null($capabilityRequirementMatch->match_status_id)) {
                $capabilityRequirementMatch->match_status_id = 1;
            }
        });

        static::created(function ($capabilityRequirementMatch) {
            $capabilityRequirementMatch->matchLogs()->create([
                'action' => MatchAction::DRAW,
                'description' => 'La necesidad y la capacidad han sido empatadas con éxito.'
            ]);

            $capabilityRequirementMatch->requirement->user->notify(
                new MatchNotification($capabilityRequirementMatch, $capabilityRequirementMatch->requirement)
            );
            $capabilityRequirementMatch->capability->user->notify(
                new MatchNotification($capabilityRequirementMatch, $capabilityRequirementMatch->capability)
            );
        });
    }

    public function isOfferer(User $user): bool
    {
        return $user->id === $this->capability->user_id;
    }

    public function isApplicant(User $user): bool
    {
        return $user->id === $this->requirement->user_id;
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function capability()
    {
        return $this->belongsTo(Capability::class);
    }

    public function matchStatus()
    {
        return $this->belongsTo(MatchStatus::class);
    }

    public function matchLogs()
    {
        return $this->hasMany(MatchLog::class);
    }

    public function matchEvaluations()
    {
        return $this->hasMany(MatchEvaluation::class);
    }

    public function offererEvaluation()
    {
        return $this->hasOne(MatchEvaluation::class)
            ->whereHas('match.capability', function ($q) {
                $q->whereColumn('capabilities.user_id', 'match_evaluations.user_id');
            });
    }

    public function applicantEvaluation()
    {
        return $this->hasOne(MatchEvaluation::class)
            ->whereHas('match.requirement', function ($q) {
                $q->whereColumn('requirements.user_id', 'match_evaluations.user_id');
            });
    }

    public function actors()
    {
        $this->load('capability.user.academic.department.institution:id,name');
        $this->requirement->loadAndMountEntity();

        return [
            'offering_entity' => $this->capability->user->academic->department->institution->only('id', 'name'),
            'applicant_entity' => $this->requirement->resolveEntityInstance()->only('id', 'name'),
        ];
    }

    public function scopeApplyReportFilters(Builder $query, ReportFiltersDTO $filters): Builder
    {
        return $query
            ->when($filters->startDate, fn($q) => $q->where('created_at', '>=', $filters->startDate))
            ->when($filters->endDate, fn($q) => $q->where('created_at', '<=', $filters->endDate))
            ->when($filters->oecdSectorId, fn($q) => $this->filterBySector($q, 'oecdSectors', 'oecd_sectors', $filters->oecdSectorId))
            ->when($filters->economicSectorId, fn($q) => $this->filterBySector($q, 'economicSectors', 'economic_sectors', $filters->economicSectorId));
    }

    private function filterBySector(Builder $query, string $relation, string $table, int $sectorId): Builder
    {
        return $query->where(function ($q) use ($relation, $table, $sectorId) {
            $q->whereHas("capability.$relation", fn($s) => $this->applySectorCondition($s, $table, $sectorId))
                ->orWhereHas("requirement.$relation", fn($s) => $this->applySectorCondition($s, $table, $sectorId));
        });
    }

    private function applySectorCondition(Builder $query, string $table, int $sectorId): void
    {
        $query->where(function ($q) use ($table, $sectorId) {
            $q->where("$table.id", $sectorId)->orWhere("$table.parent_id", $sectorId);
        });
    }
}
