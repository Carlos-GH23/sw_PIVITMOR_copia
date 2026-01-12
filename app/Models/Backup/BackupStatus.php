<?php

namespace App\Models\Backup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BackupStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function backupLogs(): HasMany
    {
        return $this->hasMany(BackupLog::class);
    }
}
