<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HealthInsurances\Pages;

use AcMarche\Hrm\Filament\Resources\HealthInsurances\HealthInsuranceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class ViewHealthInsurance extends ViewRecord
{
    #[Override]
    protected static string $resource = HealthInsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::Pencil),
        ];
    }
}
