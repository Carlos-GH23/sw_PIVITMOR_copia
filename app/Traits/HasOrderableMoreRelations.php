<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasOrderableMoreRelations
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

    protected function applyRelationOrder(Builder $query, array $config, string $direction): void
    {
        $baseModel = $query->getModel();
        $currentTable = $baseModel->getTable();

        foreach ($config['relations'] as $relation) {
            $relationObj = $baseModel->$relation();

            $relatedModel = $relationObj->getRelated();
            $relatedTable = $relatedModel->getTable();

            $parentKey = method_exists($relationObj, 'getForeignKeyName')
                ? $relationObj->getForeignKeyName()
                : $relationObj->getQualifiedForeignKeyName();

            $ownerKey = method_exists($relationObj, 'getOwnerKeyName')
                ? $relationObj->getOwnerKeyName()
                : $relationObj->getQualifiedOwnerKeyName();

            $query->leftJoin(
                $relatedTable,
                "{$currentTable}.{$parentKey}",
                '=',
                "{$relatedTable}.{$ownerKey}"
            );

            $baseModel = $relatedModel;
            $currentTable = $relatedTable;
        }

        $query->orderBy(
            "{$currentTable}.{$config['order_column']}",
            $direction
        )->select("{$query->getModel()->getTable()}.*");
    }
}
