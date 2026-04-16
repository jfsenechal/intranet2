<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Pages;

use Override;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditTraining extends EditRecord
{
    #[Override]
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
