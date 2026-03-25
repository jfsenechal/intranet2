<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Users\Pages;

use AcMarche\MailingList\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nouvel utilisateur')
                ->icon(Heroicon::Plus),
        ];
    }
}
