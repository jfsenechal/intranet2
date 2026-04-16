<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Pages;

use Override;
use Filament\Actions\EditAction;
use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewTraining extends ViewRecord
{
    #[Override]
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
