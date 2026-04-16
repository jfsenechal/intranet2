<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Pages;

use Override;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditEmployee extends EditRecord
{
    #[Override]
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
