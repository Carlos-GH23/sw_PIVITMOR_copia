<?php

namespace App\Contracts;

interface EntityProvider
{
    public function getEntityCode(): ?string;

    public function getEntityName(): ?string;

    public function getEntityCategory(): ?string;

    public function loadEntityRelations(): self;
}
