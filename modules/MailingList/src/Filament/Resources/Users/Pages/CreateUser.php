<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Users\Pages;

use AcMarche\MailingList\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
