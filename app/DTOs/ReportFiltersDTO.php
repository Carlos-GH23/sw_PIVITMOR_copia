<?php

namespace App\DTOs;

use Carbon\Carbon;

final class ReportFiltersDTO
{
    public function __construct(
        public readonly Carbon $startDate,
        public readonly Carbon $endDate,
        public readonly ?int $userTypeId = null,
        public readonly ?int $oecdSectorId = null,
        public readonly ?int $economicSectorId = null,
        public readonly ?int $categoryId = null,
        public readonly ?int $researchAreaId = null,
        public readonly ?int $sniLevelId = null,
        public readonly ?string $gender = null,
        public readonly ?int $municipalityId = null,
    ) {}

    public static function fromRequest(array $filters): self
    {
        return new self(
            startDate: !empty($filters['startDate']) ? Carbon::parse($filters['startDate'])->startOfDay() : now()->subMonths(6)->startOfMonth(),
            endDate: !empty($filters['endDate']) ? Carbon::parse($filters['endDate'])->endOfDay() : now()->endOfDay(),
            userTypeId: !empty($filters['userType']) ? (int) $filters['userType'] : null,
            oecdSectorId: !empty($filters['oecdSector']) ? (int) $filters['oecdSector'] : null,
            economicSectorId: !empty($filters['economicSector']) ? (int) $filters['economicSector'] : null,
            categoryId: !empty($filters['category']) ? (int) $filters['category'] : null,
            researchAreaId: !empty($filters['researchArea']) ? (int) $filters['researchArea'] : null,
            sniLevelId: !empty($filters['sniLevel']) ? (int) $filters['sniLevel'] : null,
            gender: !empty($filters['gender']) ? (string) $filters['gender'] : null,
            municipalityId: !empty($filters['municipality']) ? (int) $filters['municipality'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'startDate' => $this->startDate->format('Y-m-d'),
            'endDate' => $this->endDate->format('Y-m-d'),
            'userType' => $this->userTypeId,
            'oecdSector' => $this->oecdSectorId,
            'economicSector' => $this->economicSectorId,
            'category' => $this->categoryId,
            'researchArea' => $this->researchAreaId,
            'sniLevel' => $this->sniLevelId,
            'gender' => $this->gender,
            'municipality' => $this->municipalityId,
        ];
    }
}
