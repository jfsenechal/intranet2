<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\FollowUp\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\Pst\Filament\Resources\FollowUp\FollowUpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditFollowUp extends EditRecord
{
    #[Override]
    protected static string $resource = FollowUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
