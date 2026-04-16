<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Odd\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\Pst\Filament\Resources\Odd\OddResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditOdd extends EditRecord
{
    #[Override]
    protected static string $resource = OddResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
