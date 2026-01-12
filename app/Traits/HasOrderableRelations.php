<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasOrderableRelations
{
   
    abstract protected function getOrderableRelations(): array;

    protected function applyOrdering(Builder $query, string $orderField, string $direction = 'asc'): void
    {
        $relations = $this->getOrderableRelations();

        if (isset($relations[$orderField])) {
            $this->applyRelationOrder($query, $relations[$orderField], $direction);
        } else {
            $query->orderBy($orderField, $direction);
        }
    }

    private function applyRelationOrder(Builder $query, array $config, string $direction): void
    {
        [$table, $foreignKey, $orderColumn] = $config;
        $baseTable = $query->getModel()->getTable();

        $query->leftJoin($table, "{$table}.id", '=', "{$baseTable}.{$foreignKey}")
            ->orderBy("{$table}.{$orderColumn}", $direction)
            ->select("{$baseTable}.*");
    }
}