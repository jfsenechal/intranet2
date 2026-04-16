<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Directions\Pages;

use AcMarche\Hrm\Filament\Resources\Directions\DirectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

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
