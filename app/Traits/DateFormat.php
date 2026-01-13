<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateFormat
{
    /**
     * Format date to text format (e.g., "10 de enero de 2024").
     *
     * @param mixed $date
     * @return string|null
     */
    protected function textFormatDate($date): ?string
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if (!$date instanceof Carbon) {
            return null;
        }

        return $date->translatedFormat('d \d\e F \d\e Y');
    }

    /**
     * Format date to short format (e.g., "10/01/2024").
     *
     * @param mixed $date
     * @return string|null
     */
    protected function shortFormatDate($date): ?string
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if (!$date instanceof Carbon) {
            return null;
        }

        return $date->format('d/m/Y');
    }

    /**
     * Format datetime to text format with time (e.g., "10 de enero de 2024 15:30").
     *
     * @param mixed $datetime
     * @return string|null
     */
    protected function textFormatDateTime($datetime): ?string
    {
        if (!$datetime) {
            return null;
        }

        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime);
        }

        if (!$datetime instanceof Carbon) {
            return null;
        }

        return $datetime->translatedFormat('d \d\e F \d\e Y H:i');
    }
}
