<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employers;

use AcMarche\Hrm\Filament\Resources\Employers\Pages\CreateEmployer;
use AcMarche\Hrm\Filament\Resources\Employers\Pages\EditEmployer;
use AcMarche\Hrm\Filament\Resources\Employers\Pages\ListEmployers;
use AcMarche\Hrm\Models\Employer;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class EmployerResource extends Resource
{
    #[Override]
    protected static ?string $model = Employer::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Configuration';

    #[Override]
    protected static ?int $navigationSort = 4;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-building-office';
    }

    public static function getNavigationLabel(): string
    {
        return 'Employeurs';
    }

    public static function getModelLabel(): string
    {
        return 'Employeur';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Employeurs';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(150)
                            ->live(onBlur: true),
                        Select::make('parent_id')
                            ->label('Employeur parent')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
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
                TextColumn::make('parent.name')
                    ->label('Parent')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('directions_count')
                    ->label('Directions')
                    ->counts('directions')
                    ->sortable(),
                TextColumn::make('employees_count')
                    ->label('Employés')
                    ->counts('employees')
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
            'index' => ListEmployers::route('/'),
            'create' => CreateEmployer::route('/create'),
            'edit' => EditEmployer::route('/{record}/edit'),
        ];
    }
}
