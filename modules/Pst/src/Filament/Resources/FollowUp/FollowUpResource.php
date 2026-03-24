<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\FollowUp;

use AcMarche\Pst\Filament\Resources\FollowUp\Schemas\FollowUpForm;
use AcMarche\Pst\Filament\Resources\FollowUp\Tables\FollowUpTables;
use AcMarche\Pst\Models\FollowUp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

final class FollowUpResource extends Resource
{
    protected static ?string $model = FollowUp::class;

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return FollowUpForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FollowUpTables::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFollowUps::route('/'),
            'create' => Pages\CreateFollowUp::route('/create'),
            'view' => Pages\ViewFollowUp::route('/{record}'),
            'edit' => Pages\EditFollowUp::route('/{record}/edit'),
        ];
    }
}
