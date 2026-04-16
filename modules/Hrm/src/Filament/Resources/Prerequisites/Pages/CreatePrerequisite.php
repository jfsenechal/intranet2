<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Prerequisites\Pages;

use Override;
use AcMarche\Hrm\Filament\Resources\Prerequisites\PrerequisiteResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePrerequisite extends CreateRecord
{
    #[Override]
    protected static string $resource = PrerequisiteResource::class;
}
