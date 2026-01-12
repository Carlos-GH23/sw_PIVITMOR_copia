<?php

namespace App\Traits;

trait Importable
{
    public static function getCsvColumnMapping(): array
    {
        return [];
    }

    /**
     * Get the CSV validation rules for the model.
     *
     * @return array
     */

    public static function getCsvValidationRules(): array
    {
        return [];
    }
}
