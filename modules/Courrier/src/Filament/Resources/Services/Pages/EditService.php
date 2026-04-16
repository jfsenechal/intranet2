<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Services\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\Courrier\Filament\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditService extends EditRecord
{
    #[Override]
    protected static string $resource = ServiceResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
