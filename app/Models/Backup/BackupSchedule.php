<?php

namespace App\Models\Backup;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'backup_frequency_id',
        'time',
        'email_notification',
    ];

    protected $casts = [
        'email_notification' => 'boolean',
    ];

    public function backupFrequency(): BelongsTo
    {
        return $this->belongsTo(BackupFrequency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function nextBackupDate(): Attribute
    {
        return Attribute::make(
            get: function (): ?Carbon {
                if (!$this->backupFrequency || !$this->time) {
                    return null;
                }

                [$hour, $minute] = explode(':', substr($this->time, 0, 5));
                $nextBackup = Carbon::today()->setTime((int)$hour, (int)$minute, 0);
                $now = Carbon::now();

                return match ($this->backup_frequency_id) {
                    1 => $this->calculateDailyBackup($nextBackup, $now),
                    2 => $this->calculateWeeklyBackup($nextBackup, $now, (int)$hour, (int)$minute),
                    3 => $this->calculateMonthlyBackup($nextBackup, $now, (int)$hour, (int)$minute),
                    default => null,
                };
            }
        );
    }

    private function calculateDailyBackup(Carbon $nextBackup, Carbon $now): Carbon
    {
        return $nextBackup->lessThanOrEqualTo($now) ? $nextBackup->addDay() : $nextBackup;
    }

    private function calculateWeeklyBackup(Carbon $nextBackup, Carbon $now, int $hour, int $minute): Carbon
    {
        $nextBackup->next(Carbon::MONDAY)->setTime($hour, $minute, 0);
        if ($nextBackup->lessThanOrEqualTo($now)) {
            $nextBackup->addWeek();
        }
        return $nextBackup;
    }

    private function calculateMonthlyBackup(Carbon $nextBackup, Carbon $now, int $hour, int $minute): Carbon
    {
        $nextBackup->day(1)->setTime($hour, $minute, 0);
        if ($nextBackup->lessThanOrEqualTo($now)) {
            $nextBackup->addMonthNoOverflow()->day(1)->setTime($hour, $minute, 0);
        }
        return $nextBackup;
    }
}
