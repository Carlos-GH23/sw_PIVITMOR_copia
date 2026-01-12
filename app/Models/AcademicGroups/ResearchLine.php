<?php

namespace App\Models\AcademicGroups;

use App\Contracts\EntityResolvable;
use App\Models\Academic;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Institution\Department;
use App\Models\File;
use App\Models\Keyword;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;

class ResearchLine extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, UnifiedSearchable, MountsEntity;
    protected $table = 'research_lines';
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'department_id',
    ];

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

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class);
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class);
    }

    public function logo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function keywords()
    {
        return $this->morphMany(Keyword::class, 'keywordable');
    }

    public static function getCsvColumnMapping(): array
    {
        return [
            'nombre' => 'name',
            'descripcion' => 'description',
        ];
    }

    public static function getCsvValidationRules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
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
            'department',
            'academics.photo',
            'academics.department',
            'economicSectors',
            'oecdSectors',
            'logo',
            'files',
            'keywords',
        ]);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->where('institution_id', Auth::user()->institution?->id);
        });
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $this->load('keywords');
        $institution = $this->department?->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'resource_type' => 'research_line',
            'oecd_sector_ids' => $this->oecdSectors->pluck('id'),
            'economic_sector_ids' => $this->economicSectors->pluck('id'),
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            // searchable
            'title' => $this->name,
            'description' => $this->description,
            'keywords' => $this->keywords->pluck('name'),
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
