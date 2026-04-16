<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Prerequisites;

use AcMarche\Hrm\Filament\Resources\Prerequisites\Pages\CreatePrerequisite;
use AcMarche\Hrm\Filament\Resources\Prerequisites\Pages\EditPrerequisite;
use AcMarche\Hrm\Filament\Resources\Prerequisites\Pages\ListPrerequisites;
use AcMarche\Hrm\Models\Prerequisite;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class PrerequisiteResource extends Resource
{
    #[Override]
    protected static ?string $model = Prerequisite::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Configuration';

    #[Override]
    protected static ?int $navigationSort = 7;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-check';
    }

    public static function getNavigationLabel(): string
    {
        return 'Prérequis';
    }

    public static function getModelLabel(): string
    {
        return 'Prérequis';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Prérequis';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('profession')
                            ->label('Profession')
                            ->maxLength(150),
                        Select::make('employer_id')
                            ->label('Employeur')
                            ->relationship('employer', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('user')
                            ->label('Utilisateur')
                            ->maxLength(150),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('title')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('profession')
                    ->label('Profession')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('employer.name')
                    ->label('Employeur')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
            ->icon(Heroicon::Pencil),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrerequisites::route('/'),
            'create' => CreatePrerequisite::route('/create'),
            'edit' => EditPrerequisite::route('/{record}/edit'),
        ];
    }
}
