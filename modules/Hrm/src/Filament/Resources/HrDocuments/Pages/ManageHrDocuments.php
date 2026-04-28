<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HrDocuments\Pages;

use AcMarche\Hrm\Filament\Resources\HrDocuments\HrDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ManageHrDocuments extends ManageRecords
{
    #[Override]
    protected static string $resource = HrDocumentResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getAllTableRecordsCount().' documents';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un document')
                ->icon(Heroicon::Plus),
        ];
    }
}
