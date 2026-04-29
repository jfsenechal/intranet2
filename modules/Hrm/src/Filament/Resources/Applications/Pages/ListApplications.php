<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Applications\Pages;

use AcMarche\Hrm\Filament\Resources\Applications\ApplicationResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ListApplications extends ListRecords
{
    #[Override]
    protected static string $resource = ApplicationResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' candidatures';
    }
}
