<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Partner\Pages;

use AcMarche\Pst\Filament\Resources\Partner\PartnerResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;
}
