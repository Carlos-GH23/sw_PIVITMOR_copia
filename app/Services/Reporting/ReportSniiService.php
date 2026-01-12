<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Enums\Gender;
use App\Models\Institution\Institution;
use App\Models\Institution\SniMembership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Services\Reporting\ChartDataBuilder;
use App\Models\Institution\SniLevel;
use App\Models\CapabilityRequirementMatch;

class ReportSniiService
{
    public function __construct(private ChartDataBuilder $chartBuilder) {}

    public function getContributionFunnel(ReportFiltersDTO $filters): array
    {
        $dataset = $this->chartBuilder->barDataset(
            'Usuarios',
            [
                $this->countRegistered($filters),
                $this->countPublishers($filters),
                $this->countLinkers($filters),
                $this->countSuccessUsers($filters),
            ],
            ['#6E795A', '#C79B71', '#581D3A', '#283C2A'],
            ['borderRadius' => 4, 'barPercentage' => 0.6]
        );

        return $this->chartBuilder->chartResponse(
            ['Registrados', 'Publican Ofertas', 'Vinculan', 'Caso de éxito'],
            [$dataset]
        );
    }

    public function getKpis(ReportFiltersDTO $filters): array
    {
        $query = $this->buildQuery($filters);

        $sniTotal = $query->clone()->count();
        $sniMale = $query->clone()->whereHas('academic', fn($q) => $q->where('gender', Gender::MASCULINO))->count();
        $sniFemale = $query->clone()->whereHas('academic', fn($q) => $q->where('gender', Gender::FEMENINO))->count();
        $sniIes = $query->clone()->whereHas('academic.department.institution.institutionType.institutionCategory', fn($q) => $q->where('code', 'IES'))->count();
        $sniCi = $query->clone()->whereHas('academic.department.institution.institutionType.institutionCategory', fn($q) => $q->where('code', 'CI'))->count();

        return [
            ['label' => 'SNII totales', 'value' => $sniTotal, 'subtitle' => 'Investigadores con SNII registrados', 'icon' => 'mdiAccountGroup'],
            ['label' => 'SNII Hombres', 'value' => $sniMale, 'subtitle' => 'Conteo por género', 'icon' => 'mdiGenderMale'],
            ['label' => 'SNII Mujeres', 'value' => $sniFemale, 'subtitle' => 'Conteo por género', 'icon' => 'mdiGenderFemale'],
            ['label' => 'SNII en IES', 'value' => $sniIes, 'subtitle' => 'Instituciones de Educación Superior', 'icon' => 'mdiSchool'],
            ['label' => 'SNII en CI', 'value' => $sniCi, 'subtitle' => 'Centros de Investigación', 'icon' => 'mdiFlask'],
        ];
    }

    public function getCharts(ReportFiltersDTO $filters): array
    {
        return [
            'levelsChart' => $this->getSniLevelsChart($filters),
            'researchAreasChart' => $this->getResearchAreasChart($filters),
            'institutionTypeChart' => $this->getInstitutionTypeChart($filters),
            'genderChart' => $this->getGenderChart($filters),
            'municipalityDistribution' => $this->getDistributionByMunicipality($filters),
            'matchActivityChart' => $this->getMatchActivityChart($filters),
        ];
    }

    private function buildQuery(ReportFiltersDTO $filters): Builder
    {
        return SniMembership::query()
            ->when($filters->startDate && $filters->endDate, function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $sub->whereDate('start_date', '<=', $filters->endDate)
                        ->whereDate('end_date', '>=', $filters->startDate);
                });
            })
            ->when($filters->sniLevelId, fn($q) => $q->where('sni_level_id', $filters->sniLevelId))
            ->when($filters->researchAreaId, fn($q) => $q->where('research_area_id', $filters->researchAreaId))
            ->when($filters->gender, fn($q) => $q->whereHas('academic', fn($sq) => $sq->where('gender', $filters->gender)))
            ->when($filters->categoryId, fn($q) => $q->whereHas(
                'academic.department.institution.institutionType',
                fn($sq) => $sq->where('institution_category_id', $filters->categoryId)
            ))
            ->when($filters->municipalityId, fn($q) => $q->whereHas(
                'academic.department.institution.location.neighborhood',
                fn($sq) => $sq->where('municipality_id', $filters->municipalityId)
            ));
    }

    private function getSniLevelsChart(ReportFiltersDTO $filters): array
    {
        $query = $this->buildQuery($filters);

        $data = $query->join('sni_levels', 'sni_memberships.sni_level_id', '=', 'sni_levels.id')
            ->join('academics', 'sni_memberships.academic_id', '=', 'academics.id')
            ->selectRaw('sni_levels.name as level, academics.gender, count(*) as count')
            ->groupBy('sni_levels.name', 'academics.gender')
            ->orderBy('sni_levels.name')
            ->get();

        $levels = $data->pluck('level')->unique()->values()->toArray();
        $maleData = [];
        $femaleData = [];

        foreach ($levels as $level) {
            $maleData[] = $data->where('level', $level)->where('gender', Gender::MASCULINO)->first()->count ?? 0;
            $femaleData[] = $data->where('level', $level)->where('gender', Gender::FEMENINO)->first()->count ?? 0;
        }

        return [
            'labels' => $levels,
            'datasets' => [
                [
                    'label' => 'Masculino',
                    'data' => $maleData,
                    'backgroundColor' => config('reporting.snii.gender.male'),
                ],
                [
                    'label' => 'Femenino',
                    'data' => $femaleData,
                    'backgroundColor' => config('reporting.snii.gender.female'),
                ],
            ]
        ];
    }

    private function getResearchAreasChart(ReportFiltersDTO $filters): array
    {
        $query = $this->buildQuery($filters);
        $colors = config('reporting.publications.pie_colors');

        $data = $query->join('research_areas', 'sni_memberships.research_area_id', '=', 'research_areas.id')
            ->selectRaw('research_areas.name as area, count(*) as count')
            ->groupBy('research_areas.name')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return [
            'labels' => $data->pluck('area')->toArray(),
            'datasets' => [
                [
                    'label' => 'Investigadores',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => $colors,
                ],
            ],
        ];
    }

    private function getInstitutionTypeChart(ReportFiltersDTO $filters): array
    {
        $query = $this->buildQuery($filters);

        $data = $query->join('academics', 'sni_memberships.academic_id', '=', 'academics.id')
            ->join('departments', 'academics.department_id', '=', 'departments.id')
            ->join('institutions', 'departments.institution_id', '=', 'institutions.id')
            ->join('institution_types', 'institutions.institution_type_id', '=', 'institution_types.id')
            ->join('institution_categories', 'institution_types.institution_category_id', '=', 'institution_categories.id')
            ->selectRaw('institution_categories.code, count(*) as count')
            ->whereIn('institution_categories.code', ['IES', 'CI'])
            ->groupBy('institution_categories.code')
            ->get();

        $iesCount = $data->where('code', 'IES')->first()->count ?? 0;
        $ciCount = $data->where('code', 'CI')->first()->count ?? 0;

        return [
            'labels' => ['IES', 'CI'],
            'datasets' => [
                [
                    'data' => [$iesCount, $ciCount],
                    'backgroundColor' => ['#6E795A', '#C79B71'],
                ]
            ]
        ];
    }

    private function getGenderChart(ReportFiltersDTO $filters): array
    {
        $query = $this->buildQuery($filters);

        $data = $query->join('academics', 'sni_memberships.academic_id', '=', 'academics.id')
            ->selectRaw('academics.gender, count(*) as count')
            ->groupBy('academics.gender')
            ->get();

        $maleCount = $data->where('gender', Gender::MASCULINO)->first()->count ?? 0;
        $femaleCount = $data->where('gender', Gender::FEMENINO)->first()->count ?? 0;

        return [
            'labels' => ['Hombres', 'Mujeres'],
            'datasets' => [
                [
                    'data' => [$maleCount, $femaleCount],
                    'backgroundColor' => [
                        config('reporting.snii.gender.male'),
                        config('reporting.snii.gender.female'),
                    ],
                ]
            ]
        ];
    }

    private function getMatchActivityChart(ReportFiltersDTO $filters): array
    {
        $userIds = $this->buildQuery($filters)
            ->join('academics', 'sni_memberships.academic_id', '=', 'academics.id')
            ->pluck('academics.user_id')
            ->unique()
            ->filter();

        if ($userIds->isEmpty()) {
            return $this->chartBuilder->chartResponse([], []);
        }

        $startDate = $filters->startDate ?? now()->subMonths(6);
        $endDate = $filters->endDate ?? now();

        $activeMatches = CapabilityRequirementMatch::query()
            ->whereIn('match_status_id', [2, 3])
            ->where(function ($q) use ($userIds) {
                $q->whereHas('capability', fn($c) => $c->whereIn('user_id', $userIds))
                    ->orWhereHas('requirement', fn($r) => $r->whereIn('user_id', $userIds));
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(DISTINCT id) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $concludedMatches = CapabilityRequirementMatch::query()
            ->whereIn('match_status_id', [4, 5])
            ->where(function ($q) use ($userIds) {
                $q->whereHas('capability', fn($c) => $c->whereIn('user_id', $userIds))
                    ->orWhereHas('requirement', fn($r) => $r->whereIn('user_id', $userIds));
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(DISTINCT id) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonths = $activeMatches->pluck('month')->merge($concludedMatches->pluck('month'))->unique()->sort()->values();

        $labels = $allMonths->map(function ($month) {
            return \Carbon\Carbon::parse($month . '-01')->locale('es')->isoFormat('MMM YYYY');
        })->toArray();

        $activeData = $allMonths->map(function ($month) use ($activeMatches) {
            return $activeMatches->where('month', $month)->first()->count ?? 0;
        })->toArray();

        $concludedData = $allMonths->map(function ($month) use ($concludedMatches) {
            return $concludedMatches->where('month', $month)->first()->count ?? 0;
        })->toArray();

        return $this->chartBuilder->chartResponse(
            $labels,
            [
                $this->chartBuilder->barDataset(
                    'Activas',
                    $activeData,
                    '#6E795A'
                ),
                $this->chartBuilder->barDataset(
                    'Concluidas',
                    $concludedData,
                    '#C79B71'
                ),
            ],
            ['stacked' => true]
        );
    }

    public function getDistributionByMunicipality(ReportFiltersDTO $filters): array
    {
        $baseQuery = $this->buildQuery($filters);

        $rankingData = $this->joinToLocation($baseQuery->clone())
            ->join('neighborhoods', 'locations.neighborhood_id', '=', 'neighborhoods.id')
            ->join('municipalities', 'neighborhoods.municipality_id', '=', 'municipalities.id')
            ->selectRaw('municipalities.name as municipality, count(*) as count')
            ->groupBy('municipalities.name')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $heatmapData = $this->joinToLocation($baseQuery->clone())
            ->select('locations.latitude', 'locations.longitude')
            ->whereNotNull('locations.latitude')
            ->whereNotNull('locations.longitude')
            ->get()
            ->map(fn($item) => ['lat' => $item->latitude, 'lng' => $item->longitude]);

        return ['ranking' => $rankingData, 'heatmap' => $heatmapData];
    }

    private function joinToLocation(Builder $query): Builder
    {
        return $query->join('academics', 'sni_memberships.academic_id', '=', 'academics.id')
            ->join('departments', 'academics.department_id', '=', 'departments.id')
            ->join('institutions', 'departments.institution_id', '=', 'institutions.id')
            ->join('locations', function ($join) {
                $join->on('institutions.id', '=', 'locations.locationable_id')
                    ->where('locations.locationable_type', Institution::class);
            });
    }

    private function countRegistered(ReportFiltersDTO $filters): int
    {
        return $this->buildQuery($filters)->count();
    }



    private function countPublishers(ReportFiltersDTO $filters): int
    {
        return $this->buildQuery($filters)
            ->whereHas('academic.user', function ($q) {
                $q->where(function ($sub) {
                    $sub->has('capabilities')
                        ->orHas('technologyServices');
                });
            })
            ->count();
    }

    private function countLinkers(ReportFiltersDTO $filters): int
    {
        return $this->buildQuery($filters)
            ->whereHas('academic.user', function ($q) {
                $q->whereHas('capabilities', function ($c) {
                    $c->whereHas('capabilityRequirementMatches', function ($m) {
                        $m->where('match_status_id', 3);
                    });
                });
            })
            ->count();
    }

    private function countSuccessUsers(ReportFiltersDTO $filters): int
    {
        return $this->buildQuery($filters)
            ->whereHas('academic.user', function ($q) {
                $q->whereHas('capabilities', function ($c) {
                    $c->whereHas('capabilityRequirementMatches', function ($m) {
                        $m->whereHas('matchEvaluations', function ($e) {
                            $e->where('is_success_story', true);
                        });
                    });
                });
            })
            ->count();
    }

    public function getAbstractTablePaginated(ReportFiltersDTO $filters, object $tableFilters): LengthAwarePaginator
    {
        $sniLevels = SniLevel::orderBy('name')->get();

        $data = $sniLevels->map(function ($level) use ($filters) {
            $memberships = $this->buildQuery($filters)
                ->where('sni_level_id', $level->id)
                ->with(['academic.user.capabilities', 'academic.user.requirements', 'academic.user.technologyServices'])
                ->get();

            $techServicesCount = $memberships->flatMap(fn($m) => $m->academic?->user?->technologyServices ?? collect())->unique('id')->count();
            $capabilitiesCount = $memberships->flatMap(fn($m) => $m->academic?->user?->capabilities ?? collect())->unique('id')->count();
            $requirementsCount = $memberships->flatMap(fn($m) => $m->academic?->user?->requirements ?? collect())->unique('id')->count();

            $capabilities = $memberships->flatMap(fn($m) => $m->academic?->user?->capabilities ?? collect());
            $requirements = $memberships->flatMap(fn($m) => $m->academic?->user?->requirements ?? collect());
            
            $capabilityMatches = $capabilities->flatMap(fn($c) => $c->capabilityRequirementMatches ?? collect());
            $requirementMatches = $requirements->flatMap(fn($r) => $r->capabilityRequirementMatches ?? collect());
            $allMatches = $capabilityMatches->merge($requirementMatches)->unique('id');

            $activeLinks = $allMatches->whereIn('match_status_id', [2, 3])->count();
            $concludedLinks = $allMatches->whereIn('match_status_id', [4, 5])->count();

            $qualitativeSummary = $this->generateQualitativeSummary(
                $techServicesCount,
                $capabilitiesCount,
                $requirementsCount,
                $activeLinks,
                $concludedLinks
            );

            return (object) [
                'id' => $level->id,
                'sni_level' => $level->name,
                'tech_service' => $techServicesCount,
                'tech_capability' => $capabilitiesCount,
                'tech_requirement' => $requirementsCount,
                'active_links' => $activeLinks,
                'concluded_links' => $concludedLinks,
                'qualitative_summary' => $qualitativeSummary,
            ];
        });

        if (!empty($tableFilters->search)) {
            $search = strtolower($tableFilters->search);
            $data = $data->filter(function ($item) use ($search) {
                return str_contains(strtolower($item->sni_level), $search) ||
                       str_contains(strtolower($item->qualitative_summary), $search);
            });
        }

        $totalRow = (object) [
            'id' => 'total',
            'sni_level' => 'Total',
            'tech_service' => $data->sum('tech_service'),
            'tech_capability' => $data->sum('tech_capability'),
            'tech_requirement' => $data->sum('tech_requirement'),
            'active_links' => $data->sum('active_links'),
            'concluded_links' => $data->sum('concluded_links'),
            'qualitative_summary' => $this->generateTotalSummary($data),
        ];

        $page = (int) $tableFilters->page;
        $rows = (int) $tableFilters->rows;
        
        $allItems = $data->values()->toArray();
        $allItems[] = $totalRow;
        
        $total = count($allItems);
        $items = array_slice($allItems, ($page - 1) * $rows, $rows);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $rows,
            $page,
            ['path' => request()->url()]
        );
    }

    private function generateQualitativeSummary(
        int $techServices,
        int $capabilities,
        int $requirements,
        int $activeLinks,
        int $concludedLinks
    ): string {
        if ($techServices === 0 && $capabilities === 0 && $requirements === 0) {
            return 'Sin actividad registrada.';
        }

        $totalVolume = $techServices + $capabilities + $requirements;
        $totalLinks = $activeLinks + $concludedLinks;
        $conclusionRate = $totalLinks > 0 ? ($concludedLinks / $totalLinks) * 100 : 0;

        if ($totalVolume >= 150) {
            $volumeAnalysis = "Alto volumen de publicaciones";
        } elseif ($totalVolume >= 50) {
            $volumeAnalysis = "Volumen moderado de actividad";
        } else {
            $volumeAnalysis = "Menor volumen, actividad selectiva";
        }

        if ($totalLinks === 0) {
            $effectivenessAnalysis = "sin vinculaciones aún.";
        } elseif ($conclusionRate >= 50) {
            $effectivenessAnalysis = "alta efectividad: alta tasa de conclusión y liderazgo en vinculaciones estratégicas.";
        } elseif ($conclusionRate >= 35) {
            $effectivenessAnalysis = "buen balance entre generación y cierre; fortalece transferencia y proyectos con impacto medible.";
        } else {
            if ($capabilities > $techServices) {
                $effectivenessAnalysis = "oportunidad: acelerar conclusión con plantillas de convenio.";
            } else {
                $effectivenessAnalysis = "menor cierre por madurez y redes emergentes.";
            }
        }

        if ($totalLinks > 0 && $conclusionRate < 30) {
            $recommendation = " Útil implementar seguimiento estructurado.";
        } elseif ($totalVolume < 20 && $totalLinks >= 2) {
            $recommendation = " Ideal para mentoría y conferencias magistrales.";
        } else {
            $recommendation = "";
        }

        return $volumeAnalysis . "; " . $effectivenessAnalysis . $recommendation;
    }

    private function generateTotalSummary($data): string
    {
        $sortedByVolume = $data->sortByDesc(function ($item) {
            return $item->tech_service + $item->tech_capability + $item->tech_requirement;
        });

        $topLevels = $sortedByVolume->take(2)->pluck('sni_level')->toArray();

        $sortedByEfficiency = $data->filter(fn($item) => ($item->active_links + $item->concluded_links) > 0)
            ->sortByDesc(function ($item) {
                $total = $item->active_links + $item->concluded_links;
                return $total > 0 ? ($item->concluded_links / $total) : 0;
            });

        $efficientLevels = $sortedByEfficiency->take(2)->pluck('sni_level')->toArray();

        $volumeText = "El volumen se concentra en " . implode(' e ', $topLevels);
        $efficiencyText = count($efficientLevels) > 0 
            ? "; " . implode(' y ', $efficientLevels) . " muestran mayor eficiencia de cierre."
            : ".";

        return $volumeText . $efficiencyText;
    }
}
