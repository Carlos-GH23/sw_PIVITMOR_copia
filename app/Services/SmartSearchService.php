<?php

namespace App\Services;

use App\Models\Academic;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Conference;
use App\Models\EconomicSocialSector;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\Institution;
use App\Models\Photo;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SmartSearchService
{
    private const PER_PAGE = 8;
    private const RESOURCE_MAP = [
        'institution' => Institution::class,
        'capability' => Capability::class,
        'requirement' => Requirement::class,
        'technology_service' => TechnologyService::class,
        'academic_offering' => AcademicOffering::class,
        'facility' => Facility::class,
        'equipment' => FacilityEquipment::class,
        'conference' => Conference::class,
    ];

    public function performCapabilitySearch(object $filters, $request): LengthAwarePaginator
    {
        $searchOptions = $this->buildSearchOptions($filters);
        $rawResults = Academic::search($filters->search ?? '*')->options($searchOptions)->raw();
        $hits = $rawResults['hits'] ?? [];

        if (empty($hits)) {
            return new LengthAwarePaginator([], 0, self::PER_PAGE, $filters->page ?? 1);
        }

        $mappedData = $this->loadAllRelatedData($hits);
        $results = $this->mapResults($hits, $mappedData);

        return new LengthAwarePaginator(
            $results,
            $rawResults['estimatedTotalHits'] ?? 0,
            self::PER_PAGE,
            $filters->page ?? 1,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    private function buildSearchOptions(object $filters): array
    {
        $filterExpressions = $this->buildFilterExpressions($filters);

        return [
            'limit' => self::PER_PAGE,
            'offset' => (int)(($filters->page ?? 1) - 1) * self::PER_PAGE,
            'filter' => implode(' AND ', $filterExpressions)
        ];
    }

    private function buildFilterExpressions(object $filters): array
    {
        $filterExpressions = [];

        $validTypes = array_keys(self::RESOURCE_MAP);
        $quotedTypes = array_map(fn($t) => "'$t'", $validTypes);
        $filterExpressions[] = 'resource_type IN [' . implode(', ', $quotedTypes) . ']';

        if (!empty($filters->social_sector)) {
            $socialSector = EconomicSocialSector::where('name', $filters->social_sector)->first();
            
            if ($socialSector) {
                $filterExpressions[] = "social_sector_ids = {$socialSector->id}";
            } else {
                $filterExpressions[] = "resource_type = 'FORCE_EMPTY'";
            }
        }

        return $filterExpressions;
    }

    private function loadAllRelatedData(array $hits): array
    {
        $economicSectorIds = [];
        $oecdSectorIds = [];
        $intellectualPropertyIds = [];
        $technologyLevelIds = [];
        $photoableIds = [];
        $companyResourceIds = [];

        foreach ($hits as $hit) {
            if (!empty($hit['economic_sector_ids'])) {
                $economicSectorIds = array_merge($economicSectorIds, $hit['economic_sector_ids']);
            }
            if (!empty($hit['oecd_sector_ids'])) {
                $oecdSectorIds = array_merge($oecdSectorIds, $hit['oecd_sector_ids']);
            }
            if (!empty($hit['intellectual_property_id'])) {
                $intellectualPropertyIds[] = $hit['intellectual_property_id'];
            }
            if (!empty($hit['technology_level_id'])) {
                $technologyLevelIds[] = $hit['technology_level_id'];
            }

            $type = $hit['resource_type'] ?? null;
            $id = $hit['model_id'] ?? null;

            if ($type && $id && isset(self::RESOURCE_MAP[$type])) {
                $photoableIds[$type][] = $id;

                if (in_array($type, ['technology_service', 'job_offer']) 
                    && ($hit['institution_category'] ?? null) === 'Empresa de Base Tecnológica') {
                    $companyResourceIds[$type][] = $id;
                }
            }
        }

        $data = [
            'socialSectors' => [],
            'photos' => [],
            'intellectualProperties' => [],
            'technologyLevels' => [],
            'companyNames' => [],
        ];

        if (!empty($economicSectorIds)) {
            $data['socialSectors']['economic'] = EconomicSector::whereIn('id', array_unique($economicSectorIds))
                ->with('economicSocialSector')
                ->get()
                ->pluck('economicSocialSector', 'id');
        }

        if (!empty($oecdSectorIds)) {
            $data['socialSectors']['oecd'] = OecdSector::whereIn('id', array_unique($oecdSectorIds))
                ->with('economicSocialSector')
                ->get()
                ->pluck('economicSocialSector', 'id');
        }

        if (!empty($intellectualPropertyIds)) {
            $data['intellectualProperties'] = IntellectualProperty::whereIn('id', array_unique($intellectualPropertyIds))
                ->pluck('name', 'id')
                ->toArray();
        }

        if (!empty($technologyLevelIds)) {
            $data['technologyLevels'] = TechnologyLevel::whereIn('id', array_unique($technologyLevelIds))
                ->pluck('name', 'id')
                ->toArray();
        }

        foreach ($photoableIds as $type => $ids) {
            $photos = Photo::where('photoable_type', self::RESOURCE_MAP[$type])
                ->whereIn('photoable_id', array_unique($ids))
                ->get()
                ->groupBy('photoable_id');

            $data['photos'][$type] = $photos;
        }

        if (!empty($companyResourceIds)) {
            $userIds = [];
            foreach ($companyResourceIds as $type => $ids) {
                $models = self::RESOURCE_MAP[$type]::whereIn('id', $ids)->get(['id', 'user_id']);
                foreach ($models as $model) {
                    $userIds[$model->user_id] = $model->id;
                }
            }

            if (!empty($userIds)) {
                $companies = User::whereIn('id', array_keys($userIds))
                    ->with('company:id,user_id,name')
                    ->get(['id']);

                foreach ($companies as $user) {
                    if ($user->company) {
                        $data['companyNames'][$user->id] = $user->company->name;
                    }
                }
            }
        }

        return $data;
    }

    private function mapResults(array $hits, array $data): Collection
    {
        return collect($hits)->map(function ($hit) use ($data) {
            $type = $hit['resource_type'] ?? '';
            $id = $hit['model_id'];
            $institutionName = $hit['institution_name'] ?? '';

            if (in_array($type, ['technology_service', 'job_offer']) 
                && ($hit['institution_category'] ?? null) === 'Empresa de Base Tecnológica') {
                $model = self::RESOURCE_MAP[$type]::find($id);
                if ($model && isset($data['companyNames'][$model->user_id])) {
                    $institutionName = $data['companyNames'][$model->user_id];
                }
            }

            return [
                'id' => $id,
                'title' => $hit['title'] ?? '',
                'technical_description' => $hit['description'] ?? '',
                'resource_type' => $type,
                'institution_name' => $institutionName,
                'institution_category' => $hit['institution_category'] ?? '',
                'economic_sectors' => $this->formatEconomicSectors($hit),
                'social_sector' => $this->extractSocialSector($hit, $data['socialSectors']),
                'intellectual_property' => $this->formatRelatedData($hit, 'intellectual_property_id', $data['intellectualProperties']),
                'technology_level' => $this->formatRelatedData($hit, 'technology_level_id', $data['technologyLevels']),
                'photos' => $this->extractPhotos($hit, $data['photos']),
            ];
        });
    }

    private function formatEconomicSectors(array $hit): array
    {
        return isset($hit['economic_sectors']) && is_array($hit['economic_sectors'])
            ? array_map(fn($name) => ['name' => $name], $hit['economic_sectors'])
            : [];
    }

    private function formatRelatedData(array $hit, string $idKey, array $dataMap): ?array
    {
        if (empty($hit[$idKey])) {
            return null;
        }

        $id = $hit[$idKey];
        $name = $dataMap[$id] ?? null;

        return $name ? ['id' => $id, 'name' => $name] : null;
    }

    private function extractSocialSector(array $hit, array $socialSectorsMap): ?array
    {
        $socialSector = null;

        if (!empty($hit['oecd_sector_ids'])) {
            foreach ($hit['oecd_sector_ids'] as $id) {
                $socialSector = $socialSectorsMap['oecd'][$id] ?? null;
                if ($socialSector) break;
            }
        }

        if (!$socialSector && !empty($hit['economic_sector_ids'])) {
            foreach ($hit['economic_sector_ids'] as $id) {
                $socialSector = $socialSectorsMap['economic'][$id] ?? null;
                if ($socialSector) break;
            }
        }

        return $socialSector ? ['name' => $socialSector->name] : null;
    }

    private function extractPhotos(array $hit, array $photosMap): array
    {
        $type = $hit['resource_type'] ?? null;
        $id = $hit['model_id'] ?? null;

        if (!$type || !$id || !isset($photosMap[$type][$id])) {
            return [];
        }

        return $photosMap[$type][$id]
            ->map(fn($photo) => ['path' => $photo->url])
            ->toArray();
    }
}
