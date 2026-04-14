<?php

declare(strict_types=1);

namespace AcMarche\Security\Filament\Resources\Modules\Tables;

use AcMarche\Security\Filament\Actions\RevokeAction;
use AcMarche\Security\Filament\Resources\Modules\ModuleResource;
use AcMarche\Security\Handler\ModuleHandler;
use AcMarche\Security\Models\Module;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class ModuleTables
{
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Intitulé')
                    ->url(fn (Module $record) => ModuleResource::getUrl('view', ['record' => $record->id])),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Accessible à tous')
                    ->icon(fn (bool $state): ?Heroicon => $state ? Heroicon::CheckCircle : null)
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_external')
                    ->label('Url externe')
                    ->icon(fn (bool $state): ?Heroicon => $state ? Heroicon::CheckCircle : null)
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function inline(Table $table, User|Model $ownerRecord): Table
    {
        return $table
            ->defaultSort('name')
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Intitulé')
                    ->url(fn (Module $record) => ModuleResource::getUrl('view', ['record' => $record->id])),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rôles'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label('Ajouter un module')
                    ->icon('tabler-plus'),
            ])
            ->recordActions([
                EditAction::make(),
                RevokeAction::make()
                    ->action(function (Module $module) use ($ownerRecord) {
                        ModuleHandler::revokeModuleFromUser($ownerRecord, $module->id);
                    }),
            ]);
    }
}
