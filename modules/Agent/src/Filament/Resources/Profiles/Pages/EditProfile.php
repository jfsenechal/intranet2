<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Profiles\Pages;

use AcMarche\Agent\Filament\Resources\Profiles\ProfileResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class EditProfile extends EditRecord
{
    #[Override]
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye),
        ];
    }
}
