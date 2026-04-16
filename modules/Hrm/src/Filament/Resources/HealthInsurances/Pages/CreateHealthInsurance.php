<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HealthInsurances\Pages;

use Override;
use AcMarche\Hrm\Filament\Resources\HealthInsurances\HealthInsuranceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateHealthInsurance extends CreateRecord
{
    #[Override]
    protected static string $resource = HealthInsuranceResource::class;
}
