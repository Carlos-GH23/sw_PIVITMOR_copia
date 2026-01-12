<?php

namespace App\Contracts;

interface EntityResolvable
{
    public function getEntityLoadPaths(): array|string;

    public function resolveEntityInstance();
}
