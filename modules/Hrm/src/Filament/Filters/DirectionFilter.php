<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Filters;

use AcMarche\Hrm\Models\Direction;
use Filament\Tables\Filters\SelectFilter;

final class DirectionFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('direction_id')
            ->label('Direction')
            ->options(fn (): array => Direction::groupedSelectOptions())
            ->searchable()
            ->preload();
    }
}
