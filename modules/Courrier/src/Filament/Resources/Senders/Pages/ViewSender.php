<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Senders\Pages;

use AcMarche\Courrier\Filament\Resources\Senders\SenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewSender extends ViewRecord
{
    protected static string $resource = SenderResource::class;

    public function getTitle(): string
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('tabler-edit'),
            Actions\DeleteAction::make()
                ->icon('tabler-trash'),
        ];
    }
}
