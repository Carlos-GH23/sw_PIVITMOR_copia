<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Enums\MatchAction;
use App\Models\CapabilityRequirementMatch;
use App\Models\Location;
use App\Models\Requirement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ReportMatchService
{
    public function getFunnelChartData(ReportFiltersDTO $filters): array
    {
        $matches = CapabilityRequirementMatch::with(['matchLogs', 'matchEvaluations', 'requirement', 'capability'])->applyReportFilters($filters)->get();
        [$publicationToMatch, $matchToAcceptance, $acceptanceToSuccess] = $this->calculateFunnelMetrics($matches);

        return [
            'labels' => ['Match', 'Aceptación', 'Éxito'],
            'datasets' => [[
                'data' => [
                    $this->average($publicationToMatch),
                    $this->average($matchToAcceptance),
                    $this->average($acceptanceToSuccess),
                ],
                'backgroundColor' => ['#6E795A', '#C79B71', '#832B56'],
                'borderWidth' => 1,
                'borderColor' => '#ffffff',
            ]],
            'totals' => [
                'matches' => $matches->count(),
                'with_both_acceptances' => count($matchToAcceptance),
                'with_success' => count($acceptanceToSuccess),
            ],
        ];
    }

    public function getMatchesTablePaginated(ReportFiltersDTO $filters, object $tableFilters): LengthAwarePaginator
    {
        $searchColumns = [
            'capability.title',
            'requirement.title',
            'matchStatus.name',
            'requirement.user.academic.department.institution.name',
            'requirement.user.company.name',
            'requirement.user.institution.name',
            'requirement.user.governmentAgency.name',
            'requirement.user.nonProfitOrganization.name',
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

    private function calculateFunnelMetrics($matches): array
    {
        $publicationToMatch = [];
        $matchToAcceptance = [];
        $acceptanceToSuccess = [];

        foreach ($matches as $match) {
            $logs = $match->matchLogs->sortBy('created_at');
            $drawLog = $logs->firstWhere('action', MatchAction::DRAW);
            $publishedAt = $match->requirement->published_at ?? $match->capability->published_at;

            if ($publishedAt && $drawLog) {
                $publicationToMatch[] = $publishedAt->diffInDays($drawLog->created_at);
            }

            if ($drawLog) {
                $offererAccepted = $logs->firstWhere('action', MatchAction::ACCEPTED_BY_OFFERER);
                $applicantAccepted = $logs->firstWhere('action', MatchAction::ACCEPTED_BY_APPLICANT);

                if ($offererAccepted && $applicantAccepted) {
                    $lastAcceptance = $offererAccepted->created_at->max($applicantAccepted->created_at);
                    $matchToAcceptance[] = $drawLog->created_at->diffInDays($lastAcceptance);
                    $evaluations = $match->matchEvaluations->whereNotNull('evaluated_at')->sortBy('evaluated_at');

                    if ($evaluations->count() >= 2) {
                        $lastEvaluationDate = $evaluations->last()->evaluated_at;
                        $acceptanceToSuccess[] = $lastAcceptance->diffInDays($lastEvaluationDate);
                    }
                }
            }
        }

        return [$publicationToMatch, $matchToAcceptance, $acceptanceToSuccess];
    }

    private function average(array $values): float
    {
        return count($values) > 0 ? round(array_sum($values) / count($values), 1) : 0;
    }

    private function transformMatch(CapabilityRequirementMatch $match): array
    {
        $ownerEntity = $match->requirement->resolveEntityInstance();

        return [
            'id' => $match->id,
            'capability' => $match->capability?->title,
            'requirement' => $match->requirement?->title,
            'owner_entity' => $ownerEntity?->only('name'),
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

    public function getHeatmapData(ReportFiltersDTO $filters): array
    {
        return CapabilityRequirementMatch::query()
            ->applyReportFilters($filters)
            ->whereHas('matchLogs', fn($q) => $q->where('action', MatchAction::ACCEPTED_BY_OFFERER))
            ->whereHas('matchLogs', fn($q) => $q->where('action', MatchAction::ACCEPTED_BY_APPLICANT))
            ->with([
                'capability.user.academic.department.institution.location',
                'requirement.user.academic.department.institution.location',
                'requirement.user.company.location',
                'requirement.user.institution.location',
                'requirement.user.governmentAgency.location',
                'requirement.user.nonProfitOrganization.location',
            ])
            ->get()
            ->flatMap(fn($match) => $this->extractMatchCoordinates($match))
            ->filter(fn($coord) => $coord['lat'] && $coord['lng'])
            ->values()
            ->toArray();
    }

    private function extractMatchCoordinates(CapabilityRequirementMatch $match): array
    {
        $points = [];

        $offererLocation = $match->capability->user->academic?->department?->institution?->location;
        if ($offererLocation) {
            $points[] = [
                'lat' => $offererLocation->latitude,
                'lng' => $offererLocation->longitude,
                'type' => 'offerer',
            ];
        }

        $applicantLocation = $this->getApplicantLocation($match->requirement);
        if ($applicantLocation) {
            $points[] = [
                'lat' => $applicantLocation->latitude,
                'lng' => $applicantLocation->longitude,
                'type' => 'applicant',
            ];
        }

        return $points;
    }

    private function getApplicantLocation(Requirement $requirement): ?Location
    {
        return $requirement->user->ownerLocation;
    }
}
