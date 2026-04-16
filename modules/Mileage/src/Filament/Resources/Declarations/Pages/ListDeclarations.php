<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Declarations\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Mileage\Filament\Resources\Declarations\DeclarationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

final class ListDeclarations extends ListRecords
{
    #[Override]
    protected static string $resource = DeclarationResource::class;

    public function getTitle(): string
    {
        return 'Mes déclarations';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nouvelle déclaration')
                ->icon('tabler-plus'),
        ];
    }
}
