<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Folders\Schemas;

use AcMarche\Agent\Models\Folder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class FolderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        Select::make('parent_id')
                            ->label('Parent')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query, ?Folder $record) => $record
                                    ? $query->whereKeyNot($record->getKey())
                                    : $query,
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('— racine —'),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
