<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Profiles\Tables;

use AcMarche\Agent\Filament\Resources\Profiles\ProfileResource;
use AcMarche\Agent\Models\Profile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

final class ProfileTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('username')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('username')
                    ->label('Identifiant')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->copyable(),
                TextColumn::make('user.last_name')
                    ->label('Nom'),
                TextColumn::make('user.first_name')
                    ->label('Prénom'),
                TextColumn::make('location')
                    ->label('Emplacement')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30),
                TextColumn::make('external_applications_count')
                    ->counts('externalApplications')
                    ->label('Applications')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('folders_count')
                    ->counts('folders')
                    ->label('Dossiers')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('no_mail')
                    ->label('Sans mail')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Modifié')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('no_mail')->label('Sans mailbox'),
                TrashedFilter::make(),
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
