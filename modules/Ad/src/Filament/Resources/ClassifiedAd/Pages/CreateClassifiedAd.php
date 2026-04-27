<?php

declare(strict_types=1);

namespace AcMarche\Ad\Filament\Resources\Ad\Pages;

use AcMarche\Ad\Events\ClassifiedAdProcessed;
use AcMarche\Ad\Filament\Resources\Ad\ClassifiedAdResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateClassifiedAd extends CreateRecord
{
    #[Override]
    protected static string $resource = ClassifiedAdResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return 'Ajouter une actualité';
    }

    protected function afterCreate(): void
    {
        event(new ClassifiedAdProcessed($this->record));
    }
}
