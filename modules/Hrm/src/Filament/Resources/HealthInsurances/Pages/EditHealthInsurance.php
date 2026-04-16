<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HealthInsurances\Pages;

use AcMarche\Hrm\Filament\Resources\HealthInsurances\HealthInsuranceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditHealthInsurance extends EditRecord
{
    #[Override]
    protected static string $resource = HealthInsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
