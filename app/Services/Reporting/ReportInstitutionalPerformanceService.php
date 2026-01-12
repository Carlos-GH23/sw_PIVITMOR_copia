<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Enums\MatchAction;
use App\Models\CapabilityRequirementMatch;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ReportInstitutionalPerformanceService
{
    public function __construct(protected ChartDataBuilder $chartBuilder) {}

    public function getMostActiveInstitutions(ReportFiltersDTO $filters, int $limit = 5): array
    {
        $topInstitutions = $this->getTopInstitutionIds($filters, $limit);

        if ($topInstitutions->isEmpty()) {
            return $this->chartBuilder->chartResponse([], []);
        }

        $datasets = [];
        $colors = config('reporting.publications.pie_colors');

        foreach ($topInstitutions as $index => $institution) {
            $trend = Trend::query(
                CapabilityRequirementMatch::query()
                    ->whereHas('matchEvaluations', fn($q) => $q->whereNotNull('evaluated_at'), '>=', 2)
                    ->whereHas('capability.user.academic.department.institution', function ($q) use ($institution) {
                        $q->where('institutions.id', $institution['id']);
                    })
            )
                ->between($filters->startDate, $filters->endDate)->perMonth()->count();

            $datasets[] = $this->chartBuilder->lineDataset(
                $institution['name'],
                $trend->pluck('aggregate')->toArray(),
                $colors[$index % count($colors)],
                ['pointRadius' => 4, 'pointHoverRadius' => 6]
            );

            $labels = $trend->pluck('date')->map(fn($date) => Carbon::parse($date)->translatedFormat('M Y'))->toArray();
        }

        return $this->chartBuilder->chartResponse($labels ?? [], $datasets);
    }

    private function getTopInstitutionIds(ReportFiltersDTO $filters, int $limit): Collection
    {
        return CapabilityRequirementMatch::with('capability.user.academic.department.institution')
            ->applyReportFilters($filters)
            ->whereHas('matchEvaluations', fn($q) => $q->whereNotNull('evaluated_at'), '>=', 2)
            ->get()
            ->groupBy(fn($match) => $match->capability->user->academic?->department?->institution?->id)
            ->map(fn($group) => [
                'id' => $group->first()->capability->user->academic?->department?->institution?->id,
                'name' => $group->first()->capability->user->academic?->department?->institution?->name,
                'count' => $group->count(),
            ])
            ->filter(fn($item) => $item['id'])
            ->sortByDesc('count')
            ->take($limit)
            ->values();
    }

    public function getGovernmentAgenciesParticipation(ReportFiltersDTO $filters): array
    {
        $matches = CapabilityRequirementMatch::with(['requirement.user.governmentAgency'])
            ->applyReportFilters($filters)
            ->whereHas('requirement.user.governmentAgency')
            ->whereHas('matchEvaluations', fn($q) => $q->whereNotNull('evaluated_at'), '>=', 2)
            ->get();

        $agencyCounts = $matches
            ->groupBy(fn($match) => $match->requirement->user->governmentAgency?->id)
            ->map(fn($group) => [
                'name' => $group->first()->requirement->user->governmentAgency?->name,
                'count' => $group->count(),
            ])
            ->filter(fn($item) => $item['name'])
            ->sortByDesc('count')
            ->values();

        $color = config('reporting.roles.Dependencia de gobierno.color');

        return $this->chartBuilder->chartResponse(
            $agencyCounts->pluck('name')->toArray(),
            [$this->chartBuilder->barDataset(
                'Vinculaciones exitosas',
                $agencyCounts->pluck('count')->toArray(),
                $color
            )]
        );
    }

    public function getMatchesTablePaginated(ReportFiltersDTO $filters, object $tableFilters): LengthAwarePaginator
    {
        $searchColumns = [
            'capability.title',
            'requirement.title',
            'matchStatus.name',
            'capability.user.academic.department.institution.name',
        ];

        $relations = [
            'capability.user.academic.department.institution',
            'capability.oecdSectors',
            'capability.economicSectors',
            'requirement.oecdSectors',
            'requirement.economicSectors',
            'requirement.user.academic.department.institution',
            'requirement.user.company',
            'requirement.user.institution',
            'requirement.user.governmentAgency',
            'requirement.user.nonProfitOrganization',
            'matchStatus',
            'matchLogs',
            'matchEvaluations',
        ];

        $query = CapabilityRequirementMatch::with($relations)->applyReportFilters($filters);

        return Search::new()
            ->add($query, $searchColumns, 'created_at')
            ->orderByDesc()
            ->beginWithWildcard()->endWithWildcard()->dontParseTerm()
            ->paginate((int) $tableFilters->rows, 'page', (int) $tableFilters->page)
            ->search($tableFilters->search)
            ->through(fn($record) => $this->transformMatch($record));
    }

    private function transformMatch(CapabilityRequirementMatch $match): array
    {
        $institution = $match->capability->user->academic?->department?->institution;

        return [
            'id' => $match->id,
            'capability' => $match->capability?->title,
            'requirement' => $match->requirement?->title,
            'institution' => $institution?->only('id', 'name'),
            'match_status' => $match->matchStatus->only('id', 'color', 'name', 'description'),
            'duration' => $this->calculateTotalDuration($match),
        ];
    }

    private function calculateTotalDuration(CapabilityRequirementMatch $match): int
    {
        $logs = $match->matchLogs->sortBy('created_at');
        $startDate = $match->requirement->published_at ?? $match->created_at;

        $rejectionLog = $logs->first(fn($log) => in_array($log->action, [
            MatchAction::REJECTED_BY_OFFERER,
            MatchAction::REJECTED_BY_APPLICANT,
        ]));

        if ($rejectionLog) {
            return $startDate->diffInDays($rejectionLog->created_at);
        }

        $offererAccepted = $logs->firstWhere('action', MatchAction::ACCEPTED_BY_OFFERER);
        $applicantAccepted = $logs->firstWhere('action', MatchAction::ACCEPTED_BY_APPLICANT);

        if ($offererAccepted && $applicantAccepted) {
            $evaluations = $match->matchEvaluations->whereNotNull('evaluated_at')->sortBy('evaluated_at');
            if ($evaluations->count() >= 2) {
                return $startDate->diffInDays($evaluations->last()->evaluated_at);
            }
            return $startDate->diffInDays($offererAccepted->created_at->max($applicantAccepted->created_at));
        }

        return $startDate->diffInDays(now());
    }
}
