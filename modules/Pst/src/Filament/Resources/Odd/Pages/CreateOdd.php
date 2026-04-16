<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Odd\Pages;

use Override;
use AcMarche\Pst\Filament\Resources\Odd\OddResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateOdd extends CreateRecord
{
    #[Override]
    protected static string $resource = OddResource::class;
}
