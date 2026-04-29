<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Internships;

use AcMarche\Hrm\Filament\Resources\Internships\Pages\CreateInternship;
use AcMarche\Hrm\Filament\Resources\Internships\Pages\EditInternship;
use AcMarche\Hrm\Filament\Resources\Internships\Pages\ListInternships;
use AcMarche\Hrm\Filament\Resources\Internships\Pages\ViewInternship;
use AcMarche\Hrm\Filament\Resources\Internships\Schemas\InternshipForm;
use AcMarche\Hrm\Filament\Resources\Internships\Schemas\InternshipInfolist;
use AcMarche\Hrm\Filament\Resources\Internships\Tables\InternshipTables;
use AcMarche\Hrm\Models\Internship;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class InternshipResource extends Resource
{
    #[Override]
    protected static ?string $model = Internship::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Listing';

    #[Override]
    protected static ?int $navigationSort = 9;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-briefcase';
    }

    public static function getNavigationLabel(): string
    {
        return 'Stages';
    }

    public static function getModelLabel(): string
    {
        return 'Stage';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Stages';
    }

    public static function form(Schema $schema): Schema
    {
        return InternshipForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InternshipInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternshipTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInternships::route('/'),
            'create' => CreateInternship::route('/create'),
            'view' => ViewInternship::route('/{record}/view'),
            'edit' => EditInternship::route('/{record}/edit'),
        ];
    }
}
