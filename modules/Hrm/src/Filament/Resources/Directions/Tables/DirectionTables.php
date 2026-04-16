<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Directions\Tables;

use Filament\Tables\Columns\TextColumn;
use AcMarche\Hrm\Filament\Resources\Directions\DirectionResource;
use AcMarche\Hrm\Models\Direction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;

final class DirectionTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('title')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('title')
                    ->label('Intitule')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Direction $record): string => DirectionResource::getUrl('view', ['record' => $record->id])),
                TextColumn::make('abbreviation')
                    ->label('Abreviation')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('director')
                    ->label('Directeur')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('employer.name')
                    ->label('Employeur')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('services_count')
                    ->label('Services')
                    ->counts('services')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
