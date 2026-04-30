<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Filters;

use AcMarche\Hrm\Models\Service;
use Filament\Tables\Filters\SelectFilter;

final class ServiceFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('service_id')
            ->label('Service')
            ->options(fn (): array => Service::groupedSelectOptions())
            ->searchable()
            ->preload();
    }
}
