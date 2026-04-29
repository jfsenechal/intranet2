<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Internships\Pages;

use AcMarche\Hrm\Filament\Actions\BackToEmployeeAction;
use AcMarche\Hrm\Filament\Resources\Internships\InternshipResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Override;

final class ViewInternship extends ViewRecord
{
    #[Override]
    protected static string $resource = InternshipResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Stage de '.$this->record->employee->last_name.' '.$this->record->employee->first_name;
    }

    protected function getHeaderActions(): array
    {
        return [
            BackToEmployeeAction::make(),
            EditAction::make()
                ->icon(Heroicon::Pencil),
            DeleteAction::make()
                ->icon(Heroicon::Trash),
        ];
    }
}
