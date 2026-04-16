<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use AcMarche\Hrm\Models\Contract;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class ContractTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('employee.last_name')
                    ->label('Agent')
                    ->formatStateUsing(fn (Contract $record): string => $record->employee->last_name.' '.$record->employee->first_name)
                    ->searchable(['last_name', 'first_name'])
                    ->sortable()
                    ->url(fn (Contract $record): string => ContractResource::getUrl('view', ['record' => $record->id])),
                TextColumn::make('employer.name')
                    ->label('Employeur')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('contractType.name')
                    ->label('Type')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('job_title')
                    ->label('Fonction')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Debut')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('work_regime')
                    ->label('Regime')
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_closed')
                    ->label('Cloture')
                    ->boolean()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('employer_id')
                    ->label('Employeur')
                    ->relationship('employer', 'name'),
                SelectFilter::make('contract_type_id')
                    ->label('Type')
                    ->relationship('contractType', 'name'),
                TernaryFilter::make('is_closed')
                    ->label('Cloture')
                    ->placeholder('Tous')
                    ->trueLabel('Clotures')
                    ->falseLabel('En cours'),
            ])
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
