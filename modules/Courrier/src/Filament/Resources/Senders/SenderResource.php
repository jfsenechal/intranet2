<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Senders;

use AcMarche\Courrier\Filament\Resources\Senders\Pages\CreateSender;
use AcMarche\Courrier\Filament\Resources\Senders\Pages\EditSender;
use AcMarche\Courrier\Filament\Resources\Senders\Pages\ListSenders;
use AcMarche\Courrier\Filament\Resources\Senders\Pages\ViewSender;
use AcMarche\Courrier\Filament\Resources\Senders\Schemas\SenderForm;
use AcMarche\Courrier\Filament\Resources\Senders\Tables\SenderTables;
use AcMarche\Courrier\Models\Sender;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

final class SenderResource extends Resource
{
    protected static ?string $model = Sender::class;

    protected static ?int $navigationSort = 7;

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string|null|UnitEnum $navigationGroup = 'Paramètres';

    protected static ?string $modelLabel = 'Expéditeur';

    protected static ?string $pluralModelLabel = 'Expéditeurs';

    public static function form(Schema $schema): Schema
    {
        return SenderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SenderTables::table($table);
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
            'index' => ListSenders::route('/'),
            'create' => CreateSender::route('/create'),
            'view' => ViewSender::route('/{record}'),
            'edit' => EditSender::route('/{record}/edit'),
        ];
    }
}
