<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Emails\Pages;

use AcMarche\MailingList\Filament\Resources\Emails\EmailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

final class ListEmails extends ListRecords
{
    protected static string $resource = EmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nouvel e-mail')
                ->icon(Heroicon::Plus),
        ];
    }
}
