<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Service\Pages;

use AcMarche\Pst\Filament\Resources\Service\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $title = 'Ajout d\'un service';
}
