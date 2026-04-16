<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Directions\Pages;

use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Directions\DirectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewDirection extends ViewRecord
{
    #[Override]
    protected static string $resource = DirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
