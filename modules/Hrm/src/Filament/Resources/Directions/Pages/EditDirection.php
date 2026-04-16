<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Directions\Pages;

use Override;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Directions\DirectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditDirection extends EditRecord
{
    #[Override]
    protected static string $resource = DirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
