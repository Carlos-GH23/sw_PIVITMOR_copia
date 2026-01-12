<?php

namespace App\Models\Backup;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'description',
        'backup_action_id',
        'backup_status_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function backupAction(): BelongsTo
    {
        return $this->belongsTo(BackupAction::class);
    }

    public function backupStatus(): BelongsTo
    {
        return $this->belongsTo(BackupStatus::class);
    }
}
