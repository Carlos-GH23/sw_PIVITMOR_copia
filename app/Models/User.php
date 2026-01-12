<?php

namespace App\Models;

use App\Contracts\EntityProvider;
use App\Models\Company\Company;
use App\Models\Institution\Institution;
use App\Traits\HasInstitution;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use App\Models\GovernmentAgency\GovernmentAgency;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasInstitution;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getRolesArray(): Collection
    {
        return $this->roles()->get()->mapWithKeys(function ($role) {
            return [$role['name'] => true];
        });
    }

    public function getPermissionArray(): Collection
    {
        return $this->getAllPermissions()->mapWithKeys(function ($permission) {
            return [$permission['name'] => true];
        });
    }

    public function canPermission(string $permissionName): bool
    {
        if (Permission::where('name', $permissionName)->exists()) {
            return $this->hasPermissionTo($permissionName);
        }
        return false;
    }

    public function photo()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type_id', 1); // photo user
    }

    public function institution()
    {
        return $this->hasOne(Institution::class);
    }

    public function academic()
    {
        return $this->hasOne(Academic::class);
    }

    public function governmentAgency()
    {
        return $this->hasOne(GovernmentAgency::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function nonProfitOrganization()
    {
        return $this->hasOne(NonProfitOrganization::class);
    }

    public function getOwnerEntityAttribute(): ?EntityProvider
    {
        if ($this->academic) {
            return $this->academic->department->institution;
        }

        return $this->company ?? $this->institution ?? $this->governmentAgency ?? $this->nonProfitOrganization;
    }

    public function getOwnerLocationAttribute(): ?Location
    {
        return $this->ownerEntity?->location;
    }

    public function capabilities()
    {
        return $this->hasMany(Capability::class);
    }

    public function technologyServices()
    {
        return $this->hasMany(TechnologyService::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}
