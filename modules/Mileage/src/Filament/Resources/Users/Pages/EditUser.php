<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Users\Pages;

use AcMarche\Mileage\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Modification de '.$this->record->fullNameAsString();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['college_trip_date'], $data['omnium'], $data['roles']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
