<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Pages;

use AcMarche\Agent\Filament\Resources\Agents\AgentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Override;

final class CreateAgent extends CreateRecord
{
    #[Override]
    protected static string $resource = AgentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid'] ??= (string) Str::uuid();
        $data['emails'] ??= [];
        $data['modules'] ??= [];

        return $data;
    }
}
