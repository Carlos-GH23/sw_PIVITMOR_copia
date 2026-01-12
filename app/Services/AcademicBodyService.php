<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\Models\AcademicGroups\AcademicBody;
use App\Services\FileService;
use App\Traits\HasOrderableRelations;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicBodyService
{
    use HasOrderableRelations;
    use SyncsOneToMany;

    public function __construct(private FileService $fileService) {}

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'degree' => ['consolidation_degrees', 'consolidation_degree_id', 'level'],
        ];
    }

    public function buildQuery(object $filters)
    {
        $user = Auth::user();
        $query = AcademicBody::query()->with('department', 'consolidationDegree')
            ->whereHas('department', function ($departmentQuery) use ($user) {
                $departmentQuery->where('institution_id', $user->institution?->id);
            })
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('key', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    })->orWhereHas('consolidationDegree', function ($q) use ($search) {
                        $q->where('level', 'LIKE', '%' . $search . '%');
                    });
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): AcademicBody
    {
        return DB::transaction(function () use ($fields) {
            $academicBody = AcademicBody::create($fields);
            $academicBody->academics()->attach($fields['academics'] ?? []);
            $academicBody->researchLines()->attach($fields['research_lines'] ?? []);
            $academicBody->economicSectors()->attach($fields['economic_sectors'] ?? []);
            $academicBody->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $academicBody->knowledgeLines()->createMany($fields['knowledge_lines'] ?? []);

            $this->fileService->storeFiles($academicBody, $fields['files'] ?? [], new FileStorageConfig(basePath: 'institution/academicBodies/files'));
            return $academicBody;
        });
    }

    public function update(AcademicBody $academicBody, array $fields): AcademicBody
    {
        return DB::transaction(function () use ($academicBody, $fields) {
            $academicBody->update($fields);
            $academicBody->academics()->sync($fields['academics'] ?? []);
            $academicBody->researchLines()->sync($fields['research_lines'] ?? []);
            $academicBody->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $academicBody->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $this->syncsOneToMany($academicBody->knowledgeLines(), $fields['knowledge_lines'], ['name', 'description']);
            $this->fileService->syncFiles($academicBody, $fields['files'] ?? [], new FileStorageConfig(basePath: 'institution/academicBodies/files'));
            return $academicBody;
        });
    }

    public function destroy(AcademicBody $academicBody): void
    {
        DB::transaction(function () use ($academicBody) {
            $academicBody->knowledgeLines()->delete();
            $academicBody->academics()->detach();
            $academicBody->researchLines()->detach();
            $academicBody->economicSectors()->detach();
            $this->fileService->deleteFiles($academicBody->files, 'private');
            $academicBody->delete();
        });
    }
}
