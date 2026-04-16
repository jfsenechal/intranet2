<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListEmployees extends ListRecords
{
    #[Override]
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter un agent')
                ->icon('tabler-plus'),
        ];
    }
}
