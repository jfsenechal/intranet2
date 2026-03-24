<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Contacts\Pages;

use AcMarche\MailingList\Filament\Resources\Contacts\ContactResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
