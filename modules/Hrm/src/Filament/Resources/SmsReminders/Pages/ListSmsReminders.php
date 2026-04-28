<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\SmsReminders\Pages;

use AcMarche\Hrm\Filament\Resources\SmsReminders\SmsReminderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ListSmsReminders extends ListRecords
{
    #[Override]
    protected static string $resource = SmsReminderResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' rappels SMS';
    }
}
