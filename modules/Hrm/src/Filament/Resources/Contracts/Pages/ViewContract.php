<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Pages;

use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewContract extends ViewRecord
{
    #[Override]
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
