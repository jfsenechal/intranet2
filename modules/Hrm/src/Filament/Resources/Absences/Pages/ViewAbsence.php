<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Pages;

use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Absences\AbsenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewAbsence extends ViewRecord
{
    #[Override]
    protected static string $resource = AbsenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
