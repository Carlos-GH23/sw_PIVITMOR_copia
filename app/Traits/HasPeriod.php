<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasPeriod
{
    public function calculatePeriod($startDate, $endDate, $referenceDate = null): array
    {
        $reference = $referenceDate ? Carbon::parse($referenceDate) : Carbon::now();
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $totalDays = $start->diffInDays($end);
        $remainingDays = $reference->diffInDays($end);
        $elapsedDays = $start->diffInDays($reference);
        $percentage = $totalDays > 0
            ? round(($elapsedDays / $totalDays) * 100, 2)
            : 0;

        return [
            'start_date' => $start,
            'end' => $end,
            'remaining_days' => round(max(0, $remainingDays)),
            'elapsed_days' => max(0, $elapsedDays),
            'total_days' => $totalDays,
            'percentage' => min(100, max(0, $percentage)),
            'is_expired' => $reference->isAfter($end),
            'is_active' => $reference->between($start, $end),
        ];
    }

    public function getPeriodInfo(): array
    {
        return $this->calculatePeriod($this->start_date, $this->end_date);
    }

    public function getRemainingDaysAttribute(): int
    {
        return max(0, Carbon::now()->diffInDays($this->end_date));
    }

    public function getPeriodPercentageAttribute(): float
    {
        $info = $this->getPeriodInfo();
        return $info['percentage'];
    }
}
