<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Pages;

use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListContracts extends ListRecords
{
    #[Override]
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un contrat')
                ->icon('tabler-plus'),
        ];
    }
}
