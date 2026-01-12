<?php

namespace App\Services;

use App\Models\Academic;
use App\Models\Capability;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Traits\ExtractMatches;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OpportunityService
{
    use ExtractMatches;
    private const MODELS_TO_EXCLUDE = [
        'academic_body',
        'company',
        'government_agency',
        'institution',
        'job_offer',
        'non_profit',
        'research_line',
    ];

    private const MODEL_CONFIG = [
        'academic' => ['model' => Academic::class, 'relation' => 'photo'],
        'capability' => ['model' => Capability::class, 'relation' => 'photos'],
        'facility' => ['model' => Facility::class, 'relation' => 'photos'],
        'facility_equipment' => ['model' => FacilityEquipment::class, 'relation' => 'photos'],
        'requirement' => ['model' => Requirement::class, 'relation' => 'photos'],
        'technology_service' => ['model' => TechnologyService::class, 'relation' => 'photos'],
    ];

    public function performUnifiedSearch($filters, $request)
    {
        $perPage = 6;

        if (!$this->hasActiveFilters($filters)) {
            return new LengthAwarePaginator([], 0, $perPage, 1, ['path' => $request->url(), 'query' => $request->query()]);
        }

        $queryTerms = collect([
            $filters->search,
            collect($filters->keywords)->implode(' ')
        ])->filter()->implode(' ');

        $query = !empty($queryTerms) ? $queryTerms : '*';

        $search = Academic::search($query)->options([
            'limit' => $perPage,
            'offset' => ($filters->page - 1) * $perPage,
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<span class="highlight-match">',
            'highlightPostTag' => '</span>',
            'showMatchesPosition' => true,
        ]);

        $this->applySearchFilters($search, $filters);

        $rawResults = $search->raw();
        $hits = collect($rawResults['hits'] ?? []);

        $recordsLoader = [];
        $groupedHits = $hits->groupBy('resource_type');

        foreach ($groupedHits as $type => $items) {
            $modelConfig = self::MODEL_CONFIG[$type] ?? null;

            if ($modelConfig) {
                $ids = $items->pluck('model_id')->toArray();

                $records = $modelConfig['model']::whereIn('id', $ids)
                    ->with($modelConfig['relation'])
                    ->get()
                    ->keyBy('id');

                $recordsLoader[$type] = $records;
            }
        }

        $formattedHits = $hits->map(function ($hit) use ($recordsLoader) {
            $type = $hit['resource_type'] ?? '';
            $id = $hit['model_id'];

            $dbRecord = $recordsLoader[$type][$id] ?? null;
            $photoUrl = null;

            if ($dbRecord) {
                $relationName = self::MODEL_CONFIG[$type]['relation'] ?? null;
                $relationData = $dbRecord->{$relationName};

                if ($relationData instanceof Collection) {
                    $photoUrl = $relationData->first()?->url;
                } elseif ($relationData) {
                    $photoUrl = $relationData->url;
                }
            }

            $photoUrl = $photoUrl ?? '/img/default-image.avif';

            return [
                'id' => $id,
                'title' => $hit['title'] ?? '',
                'description' => $hit['description'] ?? '',
                'resource_type' => $type,
                'institution_name' => $hit['institution_name'] ?? '',
                'institution_category' => $hit['institution_category'] ?? '',
                'institution_code' => $hit['institution_code'] ?? '',
                'matches' => $this->extractMatchedWords($hit),
                'photo' => $photoUrl,
            ];
        });

        $paginator = new LengthAwarePaginator(
            $formattedHits,
            $rawResults['estimatedTotalHits'],
            $perPage,
            $filters->page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $paginator;
    }

    private function applySearchFilters($search, $filters): void
    {
        if (!empty($filters->resource_types)) {
            $search->whereIn('resource_type', $filters->resource_types);
        }

        if (!empty($filters->institution_codes)) {
            $search->whereIn('institution_code', $filters->institution_codes);
        }

        if (!empty($filters->intellectual_property_ids)) {
            $search->whereIn('intellectual_property_id', $filters->intellectual_property_ids);
        }

        $search->whereNotIn('resource_type', self::MODELS_TO_EXCLUDE);
    }

    private function hasActiveFilters($filters): bool
    {
        return (
            !empty($filters->search) ||
            !empty($filters->keywords) ||
            !empty($filters->resource_types) ||
            !empty($filters->institution_codes) ||
            !empty($filters->intellectual_property_ids)
        );
    }
}
