<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Pages;

use AcMarche\Agent\Filament\Resources\Agents\AgentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditAgent extends EditRecord
{
    #[Override]
    protected static string $resource = AgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
