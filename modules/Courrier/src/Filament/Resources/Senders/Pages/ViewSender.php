<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Senders\Pages;

use Override;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use AcMarche\Courrier\Filament\Resources\Senders\SenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewSender extends ViewRecord
{
    #[Override]
    protected static string $resource = SenderResource::class;

    public function getTitle(): string
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon('tabler-edit'),
            DeleteAction::make()
                ->icon('tabler-trash'),
        ];
    }
}
