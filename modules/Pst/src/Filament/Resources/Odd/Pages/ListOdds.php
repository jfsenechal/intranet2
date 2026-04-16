<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Odd\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Pst\Filament\Resources\Odd\OddResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListOdds extends ListRecords
{
    #[Override]
    protected static string $resource = OddResource::class;

    public function getModelLabel(): string
    {
        return 'Objectif de développement durable (ODD)';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un ODD')
                ->icon('tabler-plus'),
        ];
    }
}
