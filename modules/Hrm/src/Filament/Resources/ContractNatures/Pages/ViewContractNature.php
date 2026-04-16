<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\ContractNatures\Pages;

use AcMarche\Hrm\Filament\Resources\ContractNatures\ContractNatureResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class ViewContractNature extends ViewRecord
{
    #[Override]
    protected static string $resource = ContractNatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::Pencil),
        ];
    }
}
