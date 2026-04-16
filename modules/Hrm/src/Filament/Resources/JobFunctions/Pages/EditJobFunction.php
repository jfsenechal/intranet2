<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\JobFunctions\Pages;

use AcMarche\Hrm\Filament\Resources\JobFunctions\JobFunctionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

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
