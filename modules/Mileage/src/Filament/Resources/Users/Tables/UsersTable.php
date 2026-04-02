<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Users\Tables;

use AcMarche\Mileage\Filament\Actions\RevokeAction;
use AcMarche\Mileage\Providers\MileageServiceProvider;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->whereHas('roles', fn ($q) => $q->where('module_id', MileageServiceProvider::$module_id)))
            ->columns([
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('department')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                RevokeAction::make(),
                EditAction::make(),
            ]);
    }
}
