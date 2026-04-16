<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Declarations\Pages;

use Override;
use AcMarche\Mileage\Filament\Resources\Declarations\DeclarationResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDeclaration extends CreateRecord
{
    #[Override]
    protected static string $resource = DeclarationResource::class;
}
