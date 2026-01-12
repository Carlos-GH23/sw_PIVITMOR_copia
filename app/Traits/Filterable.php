<?php

namespace App\Traits;

use Carbon\Carbon;

trait Filterable
{
    use DateFormat;

    public function getFiltersBase(array $filters): object
    {
        return (object)[
            'direction'     => $filters['direction'] ?? 'desc',
            'order'         => $filters['order'] ?? 'created_at',
            'rows'          => $filters['rows'] ?? 5,
            'search'        => $filters['search'] ?? null,
            'page'          => $filters['page'] ?? 1,
            'withTrashed'   => filter_var($filters['withTrashed'] ?? false, FILTER_VALIDATE_BOOLEAN), // solo booleanos por inertia
        ];
    }

    public function getFiltersReport(array $filters): object
    {
        return (object)[
            'startDate'         => $filters['startDate'] ?? null,
            'endDate'           => $filters['endDate'] ?? null,
            'userType'          => $filters['userType'] ?? null,
            'oecdSector'        => $filters['oecdSector'] ?? null,
            'economicSector'    => $filters['economicSector'] ?? null,
            'category'          => $filters['category'] ?? null,
            'researchArea'      => $filters['researchArea'] ?? null,
            'sniLevel'          => $filters['sniLevel'] ?? null,
            'gender'            => $filters['gender'] ?? null,
            'municipality'      => $filters['municipality'] ?? null,
        ];
    }

    public function getSearchFilters(array $filters): object
    {
        return (object)[
            'keywords' => $filters['keywords'] ?? null,
            'resource_types' => $this->parseArrayFilter($filters['resource_types'] ?? null),
            'institution_codes' => $this->parseArrayFilter($filters['institution_codes'] ?? null),
            'municipality_ids' => $this->parseArrayFilter($filters['municipality_ids'] ?? null),

            'oecd_sector_ids' => $this->parseArrayFilter($filters['oecd_sector_ids'] ?? null),
            'economic_sector_ids' => $this->parseArrayFilter($filters['economic_sector_ids'] ?? null),
            'research_area_ids' => $this->parseArrayFilter($filters['research_area_ids'] ?? null),
            'intellectual_property_ids' => $this->parseArrayFilter($filters['intellectual_property_ids'] ?? null),
            'sni_level_ids' => $this->parseArrayFilter($filters['sni_level_ids'] ?? null),
            'technology_level_min' => isset($filters['technology_level_min']) ? (int) $filters['technology_level_min'] : null,
            'technology_level_max' => isset($filters['technology_level_max']) ? (int) $filters['technology_level_max'] : null,

            'date_from' => $this->startOfDay($filters['date_from'] ?? null),
            'date_to'   => $this->endOfDay($filters['date_to'] ?? null),

            'sort_by' => $filters['sort_by'] ?? null,
            'page'   => $filters['page'] ?? 1,
        ];
    }

    public function getOpportunityFilters(array $filters): object
    {
        return (object)[
            'search' => $filters['search'] ?? null,
            'keywords' => $this->parseArrayFilter($filters['keywords'] ?? null),
            'resource_types' => $this->parseArrayFilter($filters['resource_types'] ?? null),
            'institution_codes' => $this->parseArrayFilter($filters['institution_codes'] ?? null),
            'intellectual_property_ids' => $this->parseArrayFilter($filters['intellectual_property_ids'] ?? null),
            'page'   => $filters['page'] ?? 1,
        ];
    }

    protected function parseArrayFilter($value): ?array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return array_filter($value); // Remover valores vacíos
        }

        if (is_string($value)) {
            $array = array_map('trim', explode(',', $value));
            return array_filter($array); // Remover valores vacíos
        }

        return null;
    }
}
