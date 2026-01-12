<?php

namespace App\Enums;

enum MatchAction: string
{
    case DRAW = 'draw';
    case ACCEPTED_BY_OFFERER = 'accepted_by_offerer';
    case REJECTED_BY_OFFERER = 'rejected_by_offerer';
    case ACCEPTED_BY_APPLICANT = 'accepted_by_applicant';
    case REJECTED_BY_APPLICANT = 'rejected_by_applicant';

    public function label(): string
    {
        return match ($this) {
            self::DRAW => 'Empatado con éxito',
            self::ACCEPTED_BY_OFFERER => 'Aceptado por el ofertante',
            self::REJECTED_BY_OFFERER => 'Rechazado por el ofertante',
            self::ACCEPTED_BY_APPLICANT => 'Aceptado por el demandante',
            self::REJECTED_BY_APPLICANT => 'Rechazado por el demandante',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ACCEPTED_BY_OFFERER => 'Vinculación aceptada por el ofertante.',
            self::ACCEPTED_BY_APPLICANT => 'Vinculación aceptada por el demandante.',
            self::REJECTED_BY_OFFERER => 'Vinculación rechazada por el ofertante.',
            self::REJECTED_BY_APPLICANT => 'Vinculación rechazada por el demandante.',
        };
    }

    public function statusId(): int
    {
        return match ($this) {
            self::ACCEPTED_BY_OFFERER => 3,
            self::ACCEPTED_BY_APPLICANT => 2,
            self::REJECTED_BY_OFFERER => 4,
            self::REJECTED_BY_APPLICANT => 5,
        };
    }

    public static function fromActorAndDecision(string $actor, bool $isAccepted): self
    {
        return match ([$actor, $isAccepted]) {
            ['offerer', true] => self::ACCEPTED_BY_OFFERER,
            ['applicant', true] => self::ACCEPTED_BY_APPLICANT,
            ['offerer', false] => self::REJECTED_BY_OFFERER,
            ['applicant', false] => self::REJECTED_BY_APPLICANT,
        };
    }
}
