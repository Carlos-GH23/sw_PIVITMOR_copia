<?php

namespace App\Services\Academic;

use App\Models\Academic\AcademicCertification;
use App\Services\FileService;
use App\DTOs\FileStorageConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasOrderableRelations;

class AcademicCertificationService
{
    use HasOrderableRelations;
    protected AcademicCertification $academicCertification;
    protected FileService $fileService;
    protected FileStorageConfig $configFiles;

    public function __construct(AcademicCertification $academicCertification, FileService $fileService)
    {
        $this->academicCertification = $academicCertification;
        $this->fileService = $fileService;
        $this->configFiles = new FileStorageConfig('private', 'academic/certifications/files', 'files');
    }

    public function buildQuery(object $filters)
    {
        $query = AcademicCertification::query()->with('certificationLevel')
            ->where('academic_id', Auth::user()->academic?->id ?? null)
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('certifying_entity', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('certificationLevel', 'name', 'LIKE', '%' . $search . '%');
            })->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query = $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $data): AcademicCertification | null
    {
        return DB::transaction(function () use ($data) {
            $academicCertification = AcademicCertification::create($data);
            $this->fileService->storeFiles($academicCertification, $data['files'] ?? [], $this->configFiles);
        });
    }

    public function update(AcademicCertification $academicCertification, array $data): AcademicCertification | null
    {
        return DB::transaction(function () use ($academicCertification, $data) {
            $academicCertification->update($data);
            $this->fileService->syncFiles($academicCertification, $data['files'] ?? [], $this->configFiles);
        });
    }

    public function destroy(AcademicCertification $academicCertification): void
    {
        DB::transaction(function () use ($academicCertification) {
            $this->fileService->deleteFiles($academicCertification->files, $this->configFiles->disk, true);
            $academicCertification->delete();
        });
    }

    protected function getOrderableRelations(): array
    {
        return [
            'certification_level' => ['certification_levels', 'certification_level_id', 'name'],
        ];
    }
}
