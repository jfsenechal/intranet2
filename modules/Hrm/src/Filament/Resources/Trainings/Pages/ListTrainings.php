<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListTrainings extends ListRecords
{
    #[Override]
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une formation')
                ->icon('tabler-plus'),
        ];
    }
}
