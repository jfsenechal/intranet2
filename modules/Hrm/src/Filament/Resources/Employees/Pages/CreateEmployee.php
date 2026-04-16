<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Pages;

use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateEmployee extends CreateRecord
{
    #[Override]
    protected static string $resource = EmployeeResource::class;
}
