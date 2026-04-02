<?php

declare(strict_types=1);

namespace AcMarche\Document\Filament\Resources\Categories\Pages;

use AcMarche\Document\Filament\Resources\Categories\CategoryResource;
use AcMarche\Document\Filament\Resources\Categories\Schemas\CategoryInfolist;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

final class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return $this->record->name;
    }

    public function infolist(Schema $schema): Schema
    {
        return CategoryInfolist::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('tabler-edit'),
            Actions\DeleteAction::make()
                ->icon('tabler-trash'),
        ];
    }
}
