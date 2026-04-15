<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Senders\Pages;

use AcMarche\Courrier\Filament\Resources\Senders\SenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

final class ListSenders extends ListRecords
{
    protected static string $resource = SenderResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' expéditeurs';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un expéditeur')
                ->icon('tabler-plus'),
        ];
    }
}
