<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Rates\Pages;

use AcMarche\Mileage\Filament\Resources\Rates\RateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

final class ListRates extends ListRecords
{
    #[\Override]
    protected static string $resource = RateResource::class;

    public function getTitle(): string
    {
        return 'Liste des tarifs';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un tarif')
                ->icon('tabler-plus'),
        ];
    }
}
