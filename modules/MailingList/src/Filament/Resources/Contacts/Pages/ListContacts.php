<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Contacts\Pages;

use Override;
use AcMarche\MailingList\Filament\Resources\Contacts\ContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

final class ListContacts extends ListRecords
{
    #[Override]
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nouveau contact')
                ->icon(Heroicon::Plus),
        ];
    }
}
