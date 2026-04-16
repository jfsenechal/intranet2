<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Pages;

use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class EditTraining extends EditRecord
{
    #[Override]
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
            ->icon(Heroicon::Eye),
        ];
    }
}
