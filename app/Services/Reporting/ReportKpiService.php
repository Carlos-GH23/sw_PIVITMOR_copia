<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Models\Capability;
use App\Models\CapabilityRequirementMatch;
use App\Models\Requirement;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ReportKpiService
{
    public function getKpis(ReportFiltersDTO $filters): array
    {
        return [
            [
                'label' => 'Usuarios activos',
                'value' => $this->getActiveUsersCount($filters),
                'subtitle' => 'En el periodo',
                'icon' => 'mdiAccountMultipleOutline',
            ],
            [
                'label' => 'Nuevos usuarios',
                'value' => $this->getNewUsersCount($filters),
                'subtitle' => 'Registrados',
                'icon' => 'mdiAccountPlusOutline',
            ],
            [
                'label' => 'Capacidades activas',
                'value' => $this->getActiveEntityCount(Capability::class, $filters),
                'subtitle' => 'Validadas',
                'icon' => 'mdiOffer',
            ],
            [
                'label' => 'Necesidades activas',
                'value' => $this->getActiveEntityCount(Requirement::class, $filters),
                'subtitle' => 'Validadas',
                'icon' => 'mdiHandCoin',
            ],
            [
                'label' => 'Vinculaciones aceptadas',
                'value' => $this->getSuccessfulMatchesCount($filters),
                'subtitle' => 'Total',
                'icon' => 'mdiLink',
            ],
        ];
    }

    private function getActiveUsersCount(ReportFiltersDTO $filters): int
    {
        return Activity::query()
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])
            ->whereNotNull('causer_id')
            ->when($filters->userTypeId, function ($query) use ($filters) {
                $query->where('properties->role_id', $filters->userTypeId);
            })
            ->distinct('causer_id')
            ->count('causer_id');
    }

    private function getNewUsersCount(ReportFiltersDTO $filters): int
    {
        return User::query()
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])
            ->when($filters->userTypeId, function ($query) use ($filters) {
                $query->whereHas('roles', fn($q) => $q->where('roles.id', $filters->userTypeId));
            })
            ->count();
    }

    private function getActiveEntityCount(string $modelClass, ReportFiltersDTO $filters): int
    {
        return $modelClass::query()
            ->status(3)
            ->where('is_active', true)
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])
            ->when($filters->oecdSectorId, function ($query) use ($filters) {
                $query->whereHas('oecdSectors', function ($q) use ($filters) {
                    $table = $q->getModel()->getTable();
                    $q->where("$table.id", $filters->oecdSectorId);
                });
            })
            ->when($filters->economicSectorId, function ($query) use ($filters) {
                $query->whereHas('economicSectors', function ($q) use ($filters) {
                    $table = $q->getModel()->getTable();
                    $q->where("$table.id", $filters->economicSectorId);
                });
            })
            ->count();
    }

    private function getSuccessfulMatchesCount(ReportFiltersDTO $filters): int
    {
        return CapabilityRequirementMatch::query()->where('match_status_id', 3)
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])->count();
    }
}
