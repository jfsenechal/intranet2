<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HealthInsurances\Pages;

use Override;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\HealthInsurances\HealthInsuranceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
