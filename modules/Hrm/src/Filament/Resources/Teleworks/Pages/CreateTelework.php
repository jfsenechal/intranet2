<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Teleworks\Pages;

use AcMarche\Hrm\Filament\Resources\Teleworks\TeleworkResource;
use AcMarche\Hrm\Models\Telework;
use AcMarche\Hrm\Services\TeleworkNotifier;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateTelework extends CreateRecord
{
    #[Override]
    protected static string $resource = TeleworkResource::class;

    protected static ?string $title = 'Ajouter un télétravail';

    #[Override]
    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->hidden();
    }

    protected function afterCreate(): void
    {
        /** @var Telework $telework */
        $telework = $this->record;

        TeleworkNotifier::notifyManagerOfNewRequest($telework);
    }
}
