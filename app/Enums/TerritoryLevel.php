<?php

namespace App\Enums;

enum TerritoryLevel: string
{
    case Local = 'Local';
    case Regional = 'Regional';
    case State = 'Estatal';
    case Interstate = 'Interestatal';

    public function label(): string
    {
        return match ($this) {
            self::Local => 'Local',
            self::Regional => 'Regional',
            self::State => 'Estatal',
            self::Interstate => 'Interestatal',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
