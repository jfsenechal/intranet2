<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Services\Pages;

use Override;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditService extends EditRecord
{
    #[Override]
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
