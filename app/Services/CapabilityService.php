<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\DTOs\PhotoStorageConfig;
use App\Models\Academic;
use App\Models\Capability;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Institution\Department;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CapabilityService
{
    use HasOrderableRelations;

    public function __construct(private FileService $fileService, private PhotoService $photoService) {}

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'status' => ['capability_statuses', 'capability_status_id', 'name'],
        ];
    }

    public function buildQuery(String|null $search): Builder
    {
        $user = Auth::user();

        $query = Capability::query()->with('capabilityStatus', 'files', 'department')
            ->when($search, function (Builder $query, $search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('start_date', 'LIKE', '%' . $search . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('department', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('capabilityStatus', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });

        if ($user->canPermission('capabilities.viewInstitution')) {
            $query->fromInstitution($user->institution?->id);
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

    public function getFormData(): array
    {
        $user = Auth::user();
        $department = Department::where('id', Auth::user()->academic?->department_id)->first();

        return [
            'department' => $department,
            'academics' => Academic::select('id', 'first_name', 'last_name', 'second_last_name')->where('is_active', true)
                ->whereRelation('department', 'institution_id', $user->getInstitutionId())->get(),
            'oecdSectors' => OecdSector::getHierarchy(),
            'economicSectors' => EconomicSector::getHierarchy(),
            'intellectualProperties' => IntellectualProperty::select('id', 'name')->orderBy('name')->get(),
            'techLevels'  => TechnologyLevel::select('id', 'name')->orderBy('level')->get(),
        ];
    }

    public function store(array $fields): Capability | null
    {
        return DB::transaction(function () use ($fields) {
            $capability = Capability::create($fields);

            $capability->academics()->attach($fields['academics'] ?? []);
            $capability->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $capability->economicSectors()->attach($fields['economic_sectors'] ?? []);
            $capability->keywords()->createMany($fields['keywords'] ?? []);

            $this->fileService->storeFiles($capability, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/capabilities'));
            $this->photoService->storePhotos($capability, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/capabilities'));

            return $capability;
        });
    }

    public function update(Capability $capability, array $fields): Capability | null
    {
        return DB::transaction(function () use ($capability, $fields) {
            $capability->update($fields);
            $capability->academics()->sync($fields['academics'] ?? []);
            $capability->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $capability->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $capability->keywords()->delete();
            $capability->keywords()->createMany($fields['keywords'] ?? []);

            $this->fileService->syncFiles($capability, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/capabilities'));
            $this->photoService->syncPhotos($capability, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/capabilities'));

            return $capability;
        });
    }

    public function destroy(Capability $capability): void
    {
        DB::transaction(function () use ($capability) {
            $this->fileService->deleteFiles($capability->files, 'private', true);
            $this->photoService->deletePhotos($capability->photos, 'private', true);
            $capability->keywords()->delete();
            $capability->delete();
        });
    }
}
