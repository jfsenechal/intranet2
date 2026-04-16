<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\JobFunctions\Pages;

use Override;
use Filament\Actions\DeleteAction;
use AcMarche\Hrm\Filament\Resources\JobFunctions\JobFunctionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditJobFunction extends EditRecord
{
    #[Override]
    protected static string $resource = JobFunctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
