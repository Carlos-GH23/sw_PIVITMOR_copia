<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\Requirement;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequirementService
{
    protected $requirement;
    use HasOrderableRelations;

    public function __construct(Requirement $requirement, private PhotoService $photoService)
    {
        $this->requirement = $requirement;
    }

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'status' => ['requirement_statuses', 'requirement_status_id', 'name'],
        ];
    }

    public function buildQuery(object $filters)
    {
        $user = Auth::user();

        $query = Requirement::query()->with(
            'requirementStatus',
            'department',
            'assessments.user'
        )
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('technical_description', 'LIKE', '%' . $search . '%')
                        ->orWhere('need_statement', 'LIKE', '%' . $search . '%')
                        ->orWhere('potential_applications', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('requirementStatus', fn($q) => $q->where('name', 'LIKE', "%$search%"));
                });
            });

        if ($user->canPermission('requirements.viewInstitution')) {
            $query->fromInstitution($user->institution->id);
        } else {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function buildFilters(Builder $query, object $filters)
    {
        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): Requirement | null
    {
        return DB::transaction(function () use ($fields) {
            $requirement = Requirement::create($fields);
            $requirement->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $requirement->economicSectors()->attach($fields['economic_sectors'] ?? []);
            $requirement->keywords()->createMany($fields['keywords'] ?? []);

            $this->photoService->storePhotos($requirement, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/requirements'));

            return $requirement;
        });
    }

    public function update(Requirement $requirement, array $fields): Requirement | null
    {
        return DB::transaction(function () use ($requirement, $fields) {
            $requirement->update($fields);
            $requirement->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $requirement->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $requirement->keywords()->delete();
            $requirement->keywords()->createMany($fields['keywords'] ?? []);

            $this->photoService->syncPhotos($requirement, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/requirements'));

            return $requirement;
        });
    }

    public function delete(Requirement $requirement)
    {
        return DB::transaction(function () use ($requirement) {
            $this->photoService->deletePhotos($requirement->photos, 'private', true);
            $requirement->keywords()->delete();
            $requirement->delete();
        });
    }
}
