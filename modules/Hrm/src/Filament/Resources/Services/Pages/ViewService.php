<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Services\Pages;

use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewService extends ViewRecord
{
    #[Override]
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
