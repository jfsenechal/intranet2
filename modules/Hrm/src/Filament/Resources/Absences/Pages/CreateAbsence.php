<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Pages;

use AcMarche\Hrm\Filament\Resources\Absences\AbsenceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

final class CreateAbsence extends CreateRecord
{
    protected static string $resource = AbsenceResource::class;

    public function getTitle(): string|Htmlable
    {
        if ($this->record->employe) {
            return 'Ajouter une échéance pour '.$this->record->employee->last_name.' '.$this->record->employee->first_name;
        }

        return 'Ajouter une échéance';
    }
}
