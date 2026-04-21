<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Tables;

use AcMarche\Agent\Filament\Resources\Agents\AgentResource;
use AcMarche\Agent\Models\Agent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

final class AgentTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('last_name')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable()
                    ->url(fn (Agent $record): string => AgentResource::getUrl('view', ['record' => $record->id])),
                TextColumn::make('first_name')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('username')
                    ->label('Identifiant')
                    ->badge()
                    ->copyable()
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Emplacement')
                    ->toggleable()
                    ->limit(30),
                TextColumn::make('external_applications_count')
                    ->counts('externalApplications')
                    ->label('Applications')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('folders_count')
                    ->counts('folders')
                    ->label('Dossiers')
                    ->badge()
                    ->toggleable(),
                IconColumn::make('no_mail')
                    ->label('Sans mail')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Modifié')
                    ->since()
                    ->sortable()
                    ->toggleable(),
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
