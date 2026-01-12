<?php

namespace App\Enums;

enum OrganizationType: string
{
    case IES = 'IES';
    case CI = 'CI';
    case EMPRESA = 'Empresa';
    case DEPENDENCIA_GOBIERNO = 'Dependencia de gobierno';
    case ONG = 'Organización No Gubernamental';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSelectArray(): array
    {
        return array_map(function ($case) {
            return [
                'id' => $case->value,
                'name' => $case->getLabel(),
            ];
        }, self::cases());
    }

    public function getLabel(): string
    {
        return match($this) {
            self::IES => 'IES',
            self::CI => 'CI',
            self::EMPRESA => 'Empresa',
            self::DEPENDENCIA_GOBIERNO => 'Dependencia de gobierno',
            self::ONG => 'ONG',
        };
    }
}
