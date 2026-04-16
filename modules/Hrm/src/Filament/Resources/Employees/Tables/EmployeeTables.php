<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use AcMarche\Hrm\Models\Employee;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class EmployeeTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('last_name')
            ->defaultPaginationPageOption(50)
            ->columns([
                ImageColumn::make('photo')
                    ->label('')
                    ->circular()
                    ->size(40),
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Employee $record): string => EmployeeResource::getUrl('view', ['record' => $record->id])),
                TextColumn::make('first_name')
                    ->label('Prenom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->label('Fonction')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'retired' => 'info',
                        'terminated' => 'danger',
                        'suspended' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('hired_at')
                    ->label('Entree')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_archived')
                    ->label('Archive')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'active' => 'Actif',
                        'retired' => 'Pension',
                        'terminated' => 'Sorti',
                        'suspended' => 'Suspendu',
                    ]),
                TernaryFilter::make('is_archived')
                    ->label('Archive')
                    ->placeholder('Tous')
                    ->trueLabel('Archives')
                    ->falseLabel('Non archives'),
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
