<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Recipients\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\Courrier\Filament\Resources\Recipients\RecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditRecipient extends EditRecord
{
    #[Override]
    protected static string $resource = RecipientResource::class;

    public function getTitle(): string
    {
        return $this->getRecord()->last_name.' '.$this->getRecord()->first_name;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
