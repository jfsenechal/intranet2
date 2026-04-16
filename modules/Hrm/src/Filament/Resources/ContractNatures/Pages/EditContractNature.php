<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\ContractNatures\Pages;

use Override;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\ContractNatures\ContractNatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditContractNature extends EditRecord
{
    #[Override]
    protected static string $resource = ContractNatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
