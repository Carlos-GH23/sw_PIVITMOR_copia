<?php

namespace App\Services;

use App\Models\Institution\Facility;
use Illuminate\Support\Facades\DB;
use App\Services\PhotoService;
use App\Services\FileService;
use App\DTOs\PhotoStorageConfig;
use App\DTOs\FileStorageConfig;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FacilityService
{
    protected Facility $facility;
    protected PhotoService $photoService;
    protected FileService $fileService;
    protected FileStorageConfig $configFiles;
    protected PhotoStorageConfig $configPhotos;
    use HasOrderableRelations;

    public function __construct(Facility $facility, PhotoService $photoService, FileService $fileService)
    {
        $this->facility = $facility;
        $this->photoService = $photoService;
        $this->fileService = $fileService;
        $this->configFiles = new FileStorageConfig('private', 'facilities/files', 'files');
        $this->configPhotos = new PhotoStorageConfig('private', 'facilities/photos', 'photos');
    }

    public function buildQuery(object $filters)
    {
        $query = Facility::query()->with(['facilityType', 'department'])
            ->institution()
            ->when($filters->search, function (Builder $query, $search) {
                $query->where('facilities.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('facilities.description', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('department', function ($subQuery) use ($search) {
                        $subQuery->where('departments.name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('facilityType', function ($subQuery) use ($search) {
                        $subQuery->where('facility_types.name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhere(function ($subQuery) use ($search) {
                        $searchLower = strtolower($search);
                        if (str_contains($searchLower, 'activo') && !str_contains($searchLower, 'inactivo')) {
                            $subQuery->where('is_active', true);
                        } elseif (str_contains($searchLower, 'inactivo')) {
                            $subQuery->where('is_active', false);
                        }
                    });
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): Facility | null
    {
        return DB::Transaction(function () use ($fields) {
            $facility = Facility::create($fields);
            $this->photoService->storePhotos($facility, $fields['photos'] ?? [], $this->configPhotos);
            $this->fileService->storeFiles($facility, $fields['files'] ?? [], $this->configFiles);
            return $facility;
        });
    }

    public function update(Facility $facility, array $fields): Facility | null
    {
        return DB::Transaction(function () use ($facility, $fields) {
            $facility->update($fields);
            $this->photoService->syncPhotos($facility, $fields['photos'] ?? [], $this->configPhotos);
            $this->fileService->syncFiles($facility, $fields['files'] ?? [], $this->configFiles);
            return $facility;
        });
    }

    public function destroy(Facility $facility): void
    {
        DB::Transaction(function () use ($facility) {
            $this->photoService->deletePhotos($facility->photos, $this->configPhotos->disk, true);
            $this->fileService->deleteFiles($facility->files, $this->configFiles->disk, true);
            $facility->delete();
        });
    }

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'facility_type' => ['facility_types', 'facility_type_id', 'name'],
        ];
    }
}
