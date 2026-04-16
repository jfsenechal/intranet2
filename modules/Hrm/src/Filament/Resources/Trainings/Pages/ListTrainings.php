<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Pages;

use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ListTrainings extends ListRecords
{
    #[Override]
    protected static string $resource = TrainingResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' formations';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une formation')
                ->icon('tabler-plus'),
        ];
    }
}
