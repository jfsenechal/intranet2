<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\FollowUp\Pages;

use AcMarche\Pst\Filament\Resources\FollowUp\FollowUpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditFollowUp extends EditRecord
{
    protected static string $resource = FollowUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
