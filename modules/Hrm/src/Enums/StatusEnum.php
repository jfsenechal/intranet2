<?php

namespace AcMarche\Hrm\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum StatusEnum: string implements HasLabel
{
    case ACTIVE = 'Actif';
    case APPLICATION = 'Candidature';
    case RESIGNED = 'Démission';
    case STUDENT = 'Etudiant';
    case ENDED = 'Fin';
    case CONTRACT_ENDED = 'Fin de contrat';
    case TERMINATED = 'Licenciement';
    case RETIRED = 'Pension';
    case INTERN = 'Stagiaire';

    public function getLabel(): string|Htmlable|null
    {
        return $this->value;
    }

    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
