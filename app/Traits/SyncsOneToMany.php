<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait SyncsOneToMany
{
    protected function syncsOneToMany(HasMany|MorphMany $relation, array $items, array $updatableKeys): void {
        $keepIds = collect($items)->pluck('id')->filter()->values()->all();
        $existing = empty($keepIds) ? collect() : $relation->whereIn('id', $keepIds)->get()->keyBy('id');

        $this->deleteObsoleteRecords($relation, $keepIds);

        if (empty($items)) {
            return;
        }

        $this->processItems($relation, $items, $updatableKeys, $existing);
    }

    private function deleteObsoleteRecords(HasMany|MorphMany $relation, array $keepIds): void {
        if (!empty($keepIds)) {
            $relation->getRelated()
                ->where($relation->getForeignKeyName(), $relation->getParentKey())
                ->whereNotIn('id', $keepIds)
                ->delete();
        } else {
            $relation->delete();
        }
    }

    private function processItems(HasMany|MorphMany $relation, array $items, array $updatableKeys, Collection $existing): void
    {
        foreach ($items as $attrs) {
            if (!empty($attrs['id'])) {
                $this->updateExistingRecord($existing, $attrs, $updatableKeys);
            } else {
                $this->createNewRecord($relation, $attrs, $updatableKeys);
            }
        }
    }

    private function updateExistingRecord(Collection $existing, array $attrs, array $updatableKeys): void
    {
        if (!$existing->has($attrs['id'])) {
            return;
        }

        $updateData = collect($attrs)->only($updatableKeys)->all();

        if (!empty($updateData)) {
            $existing[$attrs['id']]->update($updateData);
        }
    }

    private function createNewRecord(HasMany|MorphMany  $relation, array $attrs, array $updatableKeys): void
    {
        $createData = collect($attrs)->only($updatableKeys)->all();

        if (!empty($createData)) {
            $relation->create($createData);
        }
    }
}
