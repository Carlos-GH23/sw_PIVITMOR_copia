<?php

namespace App\Enums;

enum OecdLevel: string
{
    case MAIN_AREA = 'main_area';
    case SUBAREA = 'subarea';
    case DISCIPLINE = 'discipline';

    public function label(): string
    {
        return match ($this) {
            self::MAIN_AREA => 'Área Principal',
            self::SUBAREA => 'Subárea',
            self::DISCIPLINE => 'Disciplina',
        };
    }

    public static function toArray(): array
    {
        return [
            ['value' => self::MAIN_AREA->value, 'label' => self::MAIN_AREA->label()],
            ['value' => self::SUBAREA->value, 'label' => self::SUBAREA->label()],
            ['value' => self::DISCIPLINE->value, 'label' => self::DISCIPLINE->label()],
        ];
    }
}
