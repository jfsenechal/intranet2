<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Pages;

use Override;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditContract extends EditRecord
{
    #[Override]
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
