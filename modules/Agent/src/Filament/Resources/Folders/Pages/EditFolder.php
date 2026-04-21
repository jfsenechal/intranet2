<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Folders\Pages;

use AcMarche\Agent\Filament\Resources\Folders\FolderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditFolder extends EditRecord
{
    #[Override]
    protected static string $resource = FolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
