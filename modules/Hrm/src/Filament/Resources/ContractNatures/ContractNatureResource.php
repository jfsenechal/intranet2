<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\ContractNatures;

use Override;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use AcMarche\Hrm\Filament\Resources\ContractNatures\Pages\ListContractNatures;
use AcMarche\Hrm\Filament\Resources\ContractNatures\Pages\CreateContractNature;
use AcMarche\Hrm\Filament\Resources\ContractNatures\Pages\EditContractNature;
use AcMarche\Hrm\Models\ContractNature;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

final class ContractNatureResource extends Resource
{
    #[Override]
    protected static ?string $model = ContractNature::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Configuration';

    #[Override]
    protected static ?int $navigationSort = 2;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Natures de contrat';
    }

    public static function getModelLabel(): string
    {
        return 'Nature de contrat';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Natures de contrat';
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
                            ->maxLength(50)
                            ->live(onBlur: true),
                        TextInput::make('description')
                            ->label('Description')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('employer_id')
                            ->label('Employeur')
                            ->relationship('employer', 'name')
                            ->searchable()
                            ->preload(),
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
                EditAction::make(),
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
            'index' => ListContractNatures::route('/'),
            'create' => CreateContractNature::route('/create'),
            'edit' => EditContractNature::route('/{record}/edit'),
        ];
    }
}
