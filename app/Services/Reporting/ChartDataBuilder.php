<?php

namespace App\Services\Reporting;

use Illuminate\Support\Collection;

class ChartDataBuilder
{
    public function lineDataset(string $label, array $data, string $color, array $options = []): array
    {
        return array_merge([
            'label' => $label,
            'data' => $data,
            'borderColor' => $color,
            'backgroundColor' => $color,
            'tension' => 0.3,
            'fill' => false,
        ], $options);
    }

    public function barDataset(string $label, array $data, string|array $color, array $options = []): array
    {
        return array_merge([
            'label' => $label,
            'data' => $data,
            'backgroundColor' => $color,
            'borderColor' => $color,
            'borderWidth' => 1,
        ], $options);
    }

    public function stackedBarDataset(string $label, Collection $sectors, Collection $counts, string $color): array
    {
        return $this->barDataset(
            $label,
            $sectors->map(fn($s) => $counts->get($s->id, 0))->toArray(),
            $color
        );
    }

    public function pieChart(Collection $sectors, Collection $data, array $colors): array
    {
        $labels = [];
        $values = [];
        $usedColors = [];

        foreach ($sectors as $index => $sector) {
            if (($val = $data->get($sector->id, 0)) > 0) {
                $labels[] = $sector->name;
                $values[] = $val;
                $usedColors[] = $colors[$index % count($colors)];
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'data' => $values,
                'backgroundColor' => $usedColors,
                'borderWidth' => 1,
                'borderColor' => '#ffffff',
            ]],
        ];
    }

    public function mergeCounts(Collection ...$collections): Collection
    {
        $allKeys = collect($collections)->flatMap(fn($c) => $c->keys())->unique();

        return $allKeys->mapWithKeys(fn($key) => [
            $key => collect($collections)->sum(fn($c) => $c->get($key, 0))
        ]);
    }

    public function chartResponse(array $labels, array $datasets): array
    {
        return compact('labels', 'datasets');
    }
}
