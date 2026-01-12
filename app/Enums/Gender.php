<?php

namespace App\Enums;

enum Gender: String
{
    case MASCULINO = 'Masculino';
    case FEMENINO = 'Femenino';
    case INDISTINTO = 'Indistinto';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSelectArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
