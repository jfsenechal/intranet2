<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\ContractTypes\Pages;

use AcMarche\Hrm\Filament\Resources\ContractTypes\ContractTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class ViewContractType extends ViewRecord
{
    #[Override]
    protected static string $resource = ContractTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::Pencil),
        ];
    }
}
