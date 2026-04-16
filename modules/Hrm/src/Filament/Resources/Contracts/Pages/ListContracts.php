<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Pages;

use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;
use Illuminate\Contracts\Support\Htmlable;

final class ListContracts extends ListRecords
{
    #[Override]
    protected static string $resource = ContractResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' contrats';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un contrat')
                ->icon('tabler-plus'),
        ];
    }
}
