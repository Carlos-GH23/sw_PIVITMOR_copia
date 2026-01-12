<?php

namespace App\Enums;

enum EconomicSectorLevel: string
{
    case SECTION = 'section';
    case DIVISION = 'division';
    case GROUP = 'group';

    public function label(): string
    {
        return match ($this) {
            self::SECTION => 'Sección',
            self::DIVISION => 'División',
            self::GROUP => 'Grupo',
        };
    }

    public static function toArray(): array
    {
        return [
            ['value' => self::SECTION->value, 'label' => self::SECTION->label()],
            ['value' => self::DIVISION->value, 'label' => self::DIVISION->label()],
            ['value' => self::GROUP->value, 'label' => self::GROUP->label()],
        ];
    }
}
