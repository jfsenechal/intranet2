<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\StrategicObjective\Pages;

use AcMarche\Pst\Filament\Resources\StrategicObjective\StrategicObjectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

final class ViewStrategicObjective extends ViewRecord
{
    protected static string $resource = StrategicObjectiveResource::class;

    public function getTitle(): string
    {
        return $this->record->name ?? 'Empty name';
    }

    public function getBreadcrumbs(): array
    {
        return [
            StrategicObjectiveResource::getUrl('index') => 'Objectifs Stratégiques',
            'OS',
            // $this->getBreadcrumb(),
        ];
    }

    /**
     * no form in view
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([]);
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
