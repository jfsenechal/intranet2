<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\Absences\AbsenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListAbsences extends ListRecords
{
    #[Override]
    protected static string $resource = AbsenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une absence')
                ->icon('tabler-plus'),
        ];
    }
}
