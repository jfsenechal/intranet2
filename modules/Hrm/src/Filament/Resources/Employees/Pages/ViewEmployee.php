<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Pages;

use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Override;
use Illuminate\Contracts\Support\Htmlable;

final class ViewEmployee extends ViewRecord
{
    #[Override]
    protected static string $resource = EmployeeResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->last_name.' '.$this->record->first_name;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
            ->icon(Heroicon::Pencil),
            DeleteAction::make(),
        ];
    }
}
