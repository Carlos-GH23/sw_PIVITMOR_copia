<?php

namespace App\Contracts;

interface Matchable
{
    public function matchType(): string;

    public function canRunMatch(): bool;

    public function matchTextFields(): array;

    public function buildMatchPayload(array $match): array;

    public function isSameEntityMatch(int $id): bool;

    public function canAcceptMatchWith(int $id): bool;
}
