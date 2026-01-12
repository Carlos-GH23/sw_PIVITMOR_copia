<?php

namespace App\Traits;

use App\Contracts\EntityResolvable;

trait MountsEntity
{
    public function loadAndMountEntity(): self
    {
        if ($this instanceof EntityResolvable) {
            $this->load($this->getEntityLoadPaths());
        }

        $entity = $this instanceof EntityResolvable ? $this->resolveEntityInstance() : null;

        if ($entity) {
            $entity->load(['logo', 'location', 'contact', 'phoneNumbers', 'socialLinks']);
            if (method_exists($entity, 'loadEntityRelations')) {
                $entity->loadEntityRelations();
            }

            $this->setRelation('entity', $entity);
        }

        return $this;
    }
}
