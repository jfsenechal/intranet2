<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Tables;

use AcMarche\Hrm\Enums\StatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->limit(70),
                TextColumn::make('first_name')
                    ->label('Prenom')
                    ->searchable()
                    ->sortable()
                    ->limit(70),
                TextColumn::make('job_title')
                    ->label('Fonction')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        StatusEnum::ACTIVE->value => 'success',
                        StatusEnum::RETIRED->value => 'info',
                        StatusEnum::TERMINATED->value, StatusEnum::RESIGNED->value, StatusEnum::ENDED->value, StatusEnum::CONTRACT_ENDED->value => 'danger',
                        StatusEnum::APPLICATION->value, StatusEnum::STUDENT->value, StatusEnum::INTERN->value => 'warning',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('hired_at')
                    ->label('Entree')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->options(StatusEnum::class),
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
            ->recordAction(ViewAction::class)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
