<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Deadlines\Pages;

use AcMarche\Hrm\Filament\Resources\Deadlines\DeadlineResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDeadline extends CreateRecord
{
    protected static string $resource = DeadlineResource::class;

    protected static ?string $title = 'Ajouter une échéance';
}
