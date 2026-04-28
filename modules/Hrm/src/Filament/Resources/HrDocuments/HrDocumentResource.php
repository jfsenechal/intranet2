<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\HrDocuments;

use AcMarche\Hrm\Filament\Resources\HrDocuments\Pages\ManageHrDocuments;
use AcMarche\Hrm\Filament\Resources\HrDocuments\Schemas\HrDocumentForm;
use AcMarche\Hrm\Filament\Resources\HrDocuments\Schemas\HrDocumentInfolist;
use AcMarche\Hrm\Filament\Resources\HrDocuments\Tables\HrDocumentTables;
use AcMarche\Hrm\Models\HrDocument;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class HrDocumentResource extends Resource
{
    #[Override]
    protected static ?string $model = HrDocument::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Listing';

    #[Override]
    protected static ?int $navigationSort = 11;

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Documents';
    }

    public static function getModelLabel(): string
    {
        return 'Document';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Documents';
    }

    public static function form(Schema $schema): Schema
    {
        return HrDocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HrDocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HrDocumentTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHrDocuments::route('/'),
        ];
    }
}
