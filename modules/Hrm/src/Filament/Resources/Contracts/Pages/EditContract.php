<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Pages;

use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditContract extends EditRecord
{
    #[Override]
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
