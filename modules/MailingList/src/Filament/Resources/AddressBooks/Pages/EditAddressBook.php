<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\AddressBooks\Pages;

use AcMarche\MailingList\Filament\Resources\AddressBooks\AddressBookResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

final class EditAddressBook extends EditRecord
{
    protected static string $resource = AddressBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Supprimer')
                ->icon(Heroicon::Trash),
        ];
    }
}
