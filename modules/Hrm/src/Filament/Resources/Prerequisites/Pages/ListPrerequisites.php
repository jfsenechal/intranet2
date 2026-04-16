<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Prerequisites\Pages;

use AcMarche\Hrm\Filament\Resources\Prerequisites\PrerequisiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListPrerequisites extends ListRecords
{
    #[Override]
    protected static string $resource = PrerequisiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un prérequis')
                ->icon('tabler-plus'),
        ];
    }
}
