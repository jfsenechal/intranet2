<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Pages;

use AcMarche\Agent\Filament\Resources\Agents\AgentResource;
use AcMarche\Agent\Filament\Resources\Agents\Schemas\AgentInfolist;
use AcMarche\Agent\Models\Agent;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Override;

final class ViewAgent extends ViewRecord
{
    #[Override]
    protected static string $resource = AgentResource::class;

    public function getTitle(): string
    {
        /** @var Agent $record */
        $record = $this->record;

        return $record->full_name;
    }

    public function infolist(Schema $schema): Schema
    {
        return AgentInfolist::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
