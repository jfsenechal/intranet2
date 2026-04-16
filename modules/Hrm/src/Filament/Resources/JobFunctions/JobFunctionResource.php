<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\JobFunctions;

use AcMarche\Hrm\Filament\Resources\JobFunctions\Pages\CreateJobFunction;
use AcMarche\Hrm\Filament\Resources\JobFunctions\Pages\EditJobFunction;
use AcMarche\Hrm\Filament\Resources\JobFunctions\Pages\ListJobFunctions;
use AcMarche\Hrm\Models\JobFunction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class JobFunctionResource extends Resource
{
    #[Override]
    protected static ?string $model = JobFunction::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Configuration';

    #[Override]
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-briefcase';
    }

    public static function getNavigationLabel(): string
    {
        return 'Fonctions';
    }

    public static function getModelLabel(): string
    {
        return 'Fonction';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Fonctions';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(150),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
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
            'index' => ListJobFunctions::route('/'),
            'create' => CreateJobFunction::route('/create'),
            'edit' => EditJobFunction::route('/{record}/edit'),
        ];
    }
}
