<?php

declare(strict_types=1);

namespace AcMarche\Document\Filament\Resources\Documents\Pages;

use Override;
use AcMarche\Document\Filament\Resources\Documents\DocumentResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDocument extends CreateRecord
{
    #[Override]
    protected static string $resource = DocumentResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return 'Ajouter un document';
    }
}
