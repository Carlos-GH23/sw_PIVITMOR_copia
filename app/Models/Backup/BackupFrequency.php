<?php

namespace App\Models\Backup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BackupFrequency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function backupSchedules(): HasMany
    {
        return $this->hasMany(BackupSchedule::class);
    }
}
