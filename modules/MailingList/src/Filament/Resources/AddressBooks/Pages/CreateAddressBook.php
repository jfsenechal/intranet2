<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\AddressBooks\Pages;

use AcMarche\MailingList\Filament\Resources\AddressBooks\AddressBookResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAddressBook extends CreateRecord
{
    protected static string $resource = AddressBookResource::class;
}
