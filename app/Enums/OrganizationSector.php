<?php

namespace App\Enums;

enum OrganizationSector: string
{
    case PUBLICO = 'publico';
    case PRIVADO = 'privado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSelectArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::PUBLICO => 'Público',
            self::PRIVADO => 'Privado',
        };
    }
}
