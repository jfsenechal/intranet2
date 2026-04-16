<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\FollowUp\Pages;

use Override;
use AcMarche\Pst\Filament\Resources\FollowUp\FollowUpResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateFollowUp extends CreateRecord
{
    #[Override]
    protected static string $resource = FollowUpResource::class;
}
