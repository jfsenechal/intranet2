<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Trips\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\Mileage\Filament\Resources\Trips\TripResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditTrip extends EditRecord
{
    #[Override]
    protected static string $resource = TripResource::class;

    public function getTitle(): string
    {
        return "Modification d'un déplacement";
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
