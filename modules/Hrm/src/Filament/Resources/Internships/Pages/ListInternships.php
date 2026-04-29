<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Internships\Pages;

use AcMarche\Hrm\Filament\Resources\Internships\InternshipResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ListInternships extends ListRecords
{
    #[Override]
    protected static string $resource = InternshipResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' stages';
    }
}
