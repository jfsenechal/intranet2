<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Partner\Pages;

use AcMarche\Pst\Filament\Resources\Partner\PartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditPartner extends EditRecord
{
    protected static string $resource = PartnerResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
