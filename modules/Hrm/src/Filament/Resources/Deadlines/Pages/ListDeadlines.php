<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Deadlines\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\Deadlines\DeadlineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListDeadlines extends ListRecords
{
    #[Override]
    protected static string $resource = DeadlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une absence')
                ->icon('tabler-plus'),
        ];
    }
}
