<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\JobFunctions\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\JobFunctions\JobFunctionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListJobFunctions extends ListRecords
{
    #[Override]
    protected static string $resource = JobFunctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une fonction')
                ->icon('tabler-plus'),
        ];
    }
}
