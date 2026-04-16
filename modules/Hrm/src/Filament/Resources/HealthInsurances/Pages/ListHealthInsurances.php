<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HealthInsurances\Pages;

use Override;
use Filament\Actions\CreateAction;
use AcMarche\Hrm\Filament\Resources\HealthInsurances\HealthInsuranceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListHealthInsurances extends ListRecords
{
    #[Override]
    protected static string $resource = HealthInsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajouter une mutuelle')
                ->icon('tabler-plus'),
        ];
    }
}
