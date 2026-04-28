<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Tables;

use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use AcMarche\Hrm\Models\Training;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class TrainingTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('employee.last_name')
                    ->label('Agent')
                    ->formatStateUsing(
                        fn (Training $record): string => $record->employee->last_name.' '.$record->employee->first_name
                    )
                    ->searchable(['last_name', 'first_name'])
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Intitule')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('training_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_date')
                    ->label('Debut')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('duration_minutes')
                    ->label('Duree')
                    ->suffix('h')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('certificate_received')
                    ->label('Attestation')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('is_closed')
                    ->label('Cloture')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('training_type')
                    ->label('Type')
                    ->options([
                        'type1' => 'Type 1',
                        'type2' => 'Type 2',
                        'type3' => 'Type 3',
                    ]),
                TernaryFilter::make('certificate_received')
                    ->label('Attestation recue')
                    ->placeholder('Toutes')
                    ->trueLabel('Recues')
                    ->falseLabel('Non recues'),
                TernaryFilter::make('is_closed')
                    ->label('Cloture')
                    ->placeholder('Toutes')
                    ->trueLabel('Cloturees')
                    ->falseLabel('En cours'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->recordAction(ViewAction::class)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function relation(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->label('Intitule')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('training_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Debut')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Duree')
                    ->suffix('h')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('certificate_received')
                    ->label('Attestation')
                    ->boolean(),
                IconColumn::make('is_closed')
                    ->label('Cloture')
                    ->boolean()
                    ->toggleable(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Voir')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Training $record): string => TrainingResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
