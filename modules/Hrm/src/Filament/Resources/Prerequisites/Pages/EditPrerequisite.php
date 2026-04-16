<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Prerequisites\Pages;

use Override;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Prerequisites\PrerequisiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPrerequisite extends EditRecord
{
    #[Override]
    protected static string $resource = PrerequisiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
