<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasHierarchy
{
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function scopeIsParent(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithChildren(Builder $query, array $columns = ['id', 'name'], string $orderBy = 'name')
    {
        return $query->select($columns)
            ->isParent()
            ->with(['children' => function ($query) use ($columns) {
                $query->select([...$columns, 'parent_id'])
                    ->with(['children' => function ($query) use ($columns) {
                        $query->select([...$columns, 'parent_id']);
                    }]);
            }])
            ->orderBy($orderBy);
    }

    public static function getHierarchy(array $columns = ['id', 'name'], string $orderBy = 'name', ?int $except = null)
    {
        $query = static::withChildren($columns, $orderBy);

        if ($except) $query->where('id', '<>', $except);

        return $query->get();
    }

    public function getLevel(): int
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    public function allDescendants()
    {
        $descendants = collect([]);

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->allDescendants());
        }

        return $descendants;
    }
}
