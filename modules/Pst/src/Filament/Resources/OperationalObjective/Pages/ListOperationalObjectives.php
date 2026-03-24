<?php

namespace AcMarche\Pst\Filament\Resources\OperationalObjective\Pages;

use AcMarche\Pst\Filament\Resources\OperationalObjective\OperationalObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

final class ListOperationalObjectives extends ListRecords
{
    protected static string $resource = OperationalObjectiveResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' Objectifs Opérationnels (OO)';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un objectif opérationnel')
                ->icon('tabler-plus'),
        ];
    }
}
