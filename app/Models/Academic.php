<?php

namespace App\Models;

use App\Casts\Encrypted;
use App\Contracts\EntityResolvable;
use App\Models\Academic\AcademicBackground;
use App\Models\Academic\AcademicCertification;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Institution\Department;
use App\Models\AcademicPosition;
use App\Models\Photo;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Institution\SniMembership;
use App\Models\DesirableProfile;
use App\Models\Institution\FacilityEquipment;
use App\Models\TechnologyService;
use App\Models\Conference;
use App\Services\AcademicService;
use App\Traits\MountsEntity;
use App\Traits\UnifiedSearchable;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic extends Model implements EntityResolvable
{
    use HasFactory, SoftDeletes, UnifiedSearchable, MountsEntity;

    protected $fillable = [
        'first_name',
        'last_name',
        'second_last_name',
        'gender',
        'biography',
        'is_active',
        'user_id',
        'department_id',
        'academic_degree_id',
        'academic_position_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'first_name' => Encrypted::class,
        'last_name' => Encrypted::class,
        'second_last_name' => Encrypted::class,
        'biography' => Encrypted::class,
    ];

    protected $appends = ['full_name'];

    public function toSearchableArray(): array
    {
        $institution = $this->department->institution;
        $location = $institution?->location;

        return [
            'model_id' => $this->id,
            // filterable
            'sni_level_id' => $this->sniMembership?->sni_level_id,
            'research_area_id' => $this->sniMembership?->research_area_id,
            'municipality_id' => $location?->neighborhood?->municipality_id,
            'state_id' => $location?->neighborhood?->municipality?->state_id,
            'institution_code' => $institution?->institutionType?->institutionCategory?->code,
            'social_sector_ids' => $this->economicSectors->pluck('economic_social_sector_id')
                ->merge($this->oecdSectors->pluck('economic_social_sector_id'))
                ->unique()
                ->values()
                ->toArray(),
            // searchable
            'title' => $this->full_name,
            'description' => $this->biography,
            'keywords' => $this->knowledgeLines->pluck('name')->toArray(),
            'institution_name' =>  $institution?->name,
            'institution_category' => $institution?->institutionType?->institutionCategory?->name,

            'state' => $location?->neighborhood?->municipality?->state?->name,
            'municipality' => $location?->neighborhood?->municipality?->name,
            'resource_type' => 'academic',
        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => trim($this->first_name . ' ' . $this->last_name . ' ' . $this->second_last_name)
        );
    }

    public function getEntityLoadPaths(): string
    {
        return 'department.institution';
    }

    public function resolveEntityInstance()
    {
        return $this->department?->institution;
    }

    public function academicBackgrounds(): HasMany
    {
        return $this->hasMany(AcademicBackground::class);
    }

    public function academicCertifications(): HasMany
    {
        return $this->hasMany(AcademicCertification::class);
    }

    public function academicPosition()
    {
        return $this->belongsTo(AcademicPosition::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function academicDegree()
    {
        return $this->belongsTo(AcademicDegree::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function sniMembership()
    {
        return $this->hasOne(SniMembership::class);
    }

    public function desirableProfile()
    {
        return $this->hasOne(DesirableProfile::class);
    }

    public function oecdSectors()
    {
        return $this->belongsToMany(OecdSector::class);
    }

    public function economicSectors()
    {
        return $this->belongsToMany(EconomicSector::class);
    }

    public function capabilities(): BelongsToMany
    {
        return $this->belongsToMany(Capability::class, 'academic_capability');
    }

    public function facilityEquipments()
    {
        return $this->hasMany(FacilityEquipment::class, 'responsible_id');
    }

    public function technologyServices(): BelongsToMany
    {
        return $this->belongsToMany(TechnologyService::class, 'academic_technology_service');
    }

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_academics');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicBodies()
    {
        return $this->belongsToMany(AcademicBody::class);
    }

    public function researchLines()
    {
        return $this->belongsToMany(ResearchLine::class);
    }

    public function knowledgeLines()
    {
        return $this->morphMany(KnowledgeLine::class, 'knowledge_lineable');
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function scopeWithSearchDetails($query)
    {
        return $query->with([
            'academicPosition',
            'academicBackgrounds.academicDegree',
            'academicBackgrounds.knowledgeArea',
            'academicBackgrounds.country',
            'academicCertifications.accreditationEntity',
            'academicCertifications.certificationLevel',
            'capabilities',
            'economicSectors',
            'academicDegree',
            'department',
            'desirableProfile',
            'facilityEquipments',
            'oecdSectors',
            'researchLines',
            'photo',
            'technologyServices',
            'sniMembership.sniLevel',
            'sniMembership.researchArea',
            'academicBodies',
            'conferences',
        ]);
    }

    public function scopeInstitution($query)
    {
        return $query->whereHas('department', function ($q) {
            $q->where('institution_id', Auth::user()->institution?->id);
        });
    }

    public static function getCsvColumnMapping(): array
    {
        return [
            'nombre' => 'first_name',
            'primer_apellido' => 'last_name',
            'segundo_apellido' => 'second_last_name',
            'correo_electronico' => 'email',
        ];
    }

    public static function getCsvValidationRules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'correo_electronico' => 'required|email|unique:users,email',
        ];
    }

    public static function prepareCsvRowForImport(array $fields): array
    {
        if (Auth::check() && Auth::user()->institution) {
            $departmentId = Auth::user()->institution->departments()
                ->where('is_active', true)->value('id');

            if (!$departmentId) {
                throw new Exception('No se encontró un departamento activo para la institución del usuario');
            }

            $fields['department_id'] = $departmentId;
        } else {
            throw new Exception('El usuario debe estar autenticado y tener una institución asignada para importar académicos');
        }

        if (isset($fields['email'])) {
            $service = app(AcademicService::class);
            $fields['user_id'] = $service->createUserFromCsv($fields);
            unset($fields['email']);
        }
        return $fields;
    }

    public function phoneNumbers()
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'socialable');
    }
}
