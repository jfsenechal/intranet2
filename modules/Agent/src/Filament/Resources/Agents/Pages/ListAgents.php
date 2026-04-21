<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Pages;

use AcMarche\Agent\Filament\Resources\Agents\AgentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListAgents extends ListRecords
{
    #[Override]
    protected static string $resource = AgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un agent')
                ->icon('tabler-plus'),
        ];
    }
}
