<?php

namespace AcMarche\Pst\Filament\Resources\FollowUp\Pages;

use AcMarche\Pst\Filament\Resources\FollowUp\FollowUpResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewFollowUp extends ViewRecord
{
    protected static string $resource = FollowUpResource::class;

    public function getTitle(): string
    {
        return $this->record->property ?? 'Empty name';
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
