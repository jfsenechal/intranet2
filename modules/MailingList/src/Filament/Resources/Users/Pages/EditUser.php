<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Users\Pages;

use AcMarche\MailingList\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

final class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Supprimer')
                ->icon(Heroicon::Trash),
        ];
    }
}
