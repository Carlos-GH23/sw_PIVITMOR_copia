<?php

namespace App\Services;

use App\Models\Academic;
use App\Traits\ExtractMatches;
use App\Traits\HasPeriod;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    use HasPeriod;
    use ExtractMatches;

    public function performUnifiedSearch($filters, $request)
    {
        $perPage = 8;

        if (!$this->hasActiveFilters($filters)) {
            return new LengthAwarePaginator([], 0, $perPage, 1, ['path' => $request->url(), 'query' => $request->query()]);
        }

        $search = Academic::search($filters->keywords ?? '*')->options([
            'limit' => $perPage,
            'offset' => ($filters->page - 1) * $perPage,
            'attributesToHighlight' => ['*'],
            'highlightPreTag' => '<span class="highlight-match">', // Clase CSS personalizada
            'highlightPostTag' => '</span>',
            'showMatchesPosition' => true,
        ]);

        $this->applySearchFilters($search, $filters);

        $rawResults = $search->raw();
        $hits = collect($rawResults['hits'])->map(function ($hit) {
            return [
                'id' => $hit['model_id'],
                'title' => $hit['title'] ?? '',
                'description' => $hit['description'] ?? '',
                'resource_type' => $hit['resource_type'] ?? '',
                'institution_name' => $hit['institution_name'] ?? '',
                'institution_category' => $hit['institution_category'] ?? '',
                'institution_code' => $hit['institution_code'] ?? '',
                'municipality' => $hit['municipality'] ?? '',
                'state' => $hit['state'] ?? '',
                'period' => $this->calculatePeriod($hit['start_date'] ?? '', $hit['end_date'] ?? ''),
                'matches' => $this->extractMatchedWords($hit),
            ];
        });

        $paginator = new LengthAwarePaginator(
            $hits,
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

        if (!empty($filters->municipality_ids)) {
            $search->whereIn('municipality_id', $filters->municipality_ids);
        }

        if (!empty($filters->oecd_sector_ids)) {
            $search->whereIn('oecd_sector_ids', $filters->oecd_sector_ids);
        }

        if (!empty($filters->economic_sector_ids)) {
            $search->whereIn('economic_sector_ids', $filters->economic_sector_ids);
        }

        if (!empty($filters->intellectual_property_ids)) {
            $search->whereIn('intellectual_property_id', $filters->intellectual_property_ids);
        }

        if (!empty($filters->research_area_ids)) {
            $search->whereIn('research_area_id', $filters->research_area_ids);
        }

        if (!empty($filters->sni_level_ids)) {
            $search->whereIn('sni_level_id', $filters->sni_level_ids);
        }

        if (!empty($filters->technology_level_min)) {
            $search->where('technology_level_id', '>=', $filters->technology_level_min);
        }

        if (!empty($filters->technology_level_max)) {
            $search->where('technology_level_id', '<=', $filters->technology_level_max);
        }

        if (!empty($filters->date_from)) {
            $search->where('start_date', '>=', $filters->date_from);
        }

        if (!empty($filters->date_to)) {
            $search->where('end_date', '<=', $filters->date_to);
        }
    }

    private function hasActiveFilters($filters): bool
    {
        return (
            !empty($filters->keywords) ||
            !empty($filters->resource_types) ||
            !empty($filters->institution_codes) ||
            !empty($filters->municipality_ids) ||
            !empty($filters->oecd_sector_ids) ||
            !empty($filters->economic_sector_ids) ||
            !empty($filters->research_area_ids) ||
            !empty($filters->intellectual_property_ids) ||
            !empty($filters->sni_level_ids) ||
            !empty($filters->technology_level_min) ||
            !empty($filters->technology_level_max) ||
            !empty($filters->date_from) ||
            !empty($filters->date_to)
        );
    }
}
