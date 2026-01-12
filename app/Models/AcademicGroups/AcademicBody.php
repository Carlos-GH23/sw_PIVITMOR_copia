<?php

namespace App\Models\AcademicGroups;

use App\Contracts\EntityResolvable;
use App\Models\Academic;
use App\Models\Institution\Department;
use App\Models\File;
use App\Models\AcademicGroups\AcademicDiscipline;
use App\Models\AcademicGroups\ConsolidationDegree;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\KnowledgeLine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class AcademicBody extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, UnifiedSearchable, MountsEntity;
    protected $table = 'academic_bodies';

    protected $fillable = [
        'name',
        'key',
        'review',
        'is_active',
        'consolidation_degree_id',
        'department_id',
    ];

    public function consolidationDegree()
    {
        return $this->belongsTo(ConsolidationDegree::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getEntityLoadPaths(): string
    {
        return 'department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->department?->institution;
    }

    public function academics()
    {
        return $this->belongsToMany(Academic::class);
    }

    public function researchLines()
    {
        return $this->belongsToMany(ResearchLine::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function knowledgeLines()
    {
        return $this->morphMany(KnowledgeLine::class, 'knowledge_lineable');
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class);
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class);
    }

    public static function getCsvColumnMapping(): array
    {
        return [
            'nombre' => 'name',
            'clave' => 'key',
        ];
    }

    public static function getCsvValidationRules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:50|unique:academic_bodies,key',
        ];
    }

    public static function prepareCsvRowForImport(array $data): array
    {
        $data['is_active'] = true;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->institution) {
                $departmentId = $user->institution->departments()->where('is_active', true)->value('id');
                if ($departmentId) {
                    $data['department_id'] = $departmentId;
                }
            }
        }
        return $data;
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'academics.academicPosition',
            'academics.department',
            'academics.photo',
            'consolidationDegree',
            'department',
            'economicSectors',
            'files',
            'knowledgeLines',
            'oecdSectors',
            'researchLines.department',
            'researchLines.logo',
        ]);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $institution = $this->department?->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'academic_body',
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->name,
            'description' => $this->review,
            'keywords' => $this->researchLines->pluck('name'),
            'consolidation_degree' => $this->consolidationDegree?->name,
            'academic_discipline' => $this->academicDiscipline?->name,
            'oecd_sectors' => $this->oecdSectors->pluck('name'),
            'economic_sectors' => $this->economicSectors->pluck('name'),
            'institution_name' => $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,
            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            // sortable
            'created_at' => $this->created_at,
        ];
    }
}
