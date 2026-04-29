<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Applications;

use AcMarche\Hrm\Filament\Resources\Applications\Pages\CreateApplication;
use AcMarche\Hrm\Filament\Resources\Applications\Pages\EditApplication;
use AcMarche\Hrm\Filament\Resources\Applications\Pages\ListApplications;
use AcMarche\Hrm\Filament\Resources\Applications\Pages\ViewApplication;
use AcMarche\Hrm\Filament\Resources\Applications\Schemas\ApplicationForm;
use AcMarche\Hrm\Filament\Resources\Applications\Schemas\ApplicationInfolist;
use AcMarche\Hrm\Filament\Resources\Applications\Tables\ApplicationTables;
use AcMarche\Hrm\Models\Application;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class ApplicationResource extends Resource
{
    #[Override]
    protected static ?string $model = Application::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Listing';

    #[Override]
    protected static ?int $navigationSort = 10;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-inbox-arrow-down';
    }

    public static function getNavigationLabel(): string
    {
        return 'Candidatures';
    }

    public static function getModelLabel(): string
    {
        return 'Candidature';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Candidatures';
    }

    public static function form(Schema $schema): Schema
    {
        return ApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplications::route('/'),
            'create' => CreateApplication::route('/create'),
            'view' => ViewApplication::route('/{record}/view'),
            'edit' => EditApplication::route('/{record}/edit'),
        ];
    }
}
