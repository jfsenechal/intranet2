<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Deadlines\Pages;

use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Deadlines\DeadlineResource;
use Filament\Resources\Pages\ViewRecord;

final class ViewDeadline extends ViewRecord
{
    #[Override]
    protected static string $resource = DeadlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
            ->icon(Heroicon::Pencil),
            DeleteAction::make()
                ->icon(Heroicon::Trash),
        ];
    }
}
