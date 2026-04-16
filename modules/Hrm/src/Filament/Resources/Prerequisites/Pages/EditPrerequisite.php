<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Prerequisites\Pages;

use AcMarche\Hrm\Filament\Resources\Prerequisites\PrerequisiteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

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
