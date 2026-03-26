<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Senders;

use AcMarche\MailingList\Filament\Resources\Senders\Pages\CreateSender;
use AcMarche\MailingList\Filament\Resources\Senders\Pages\EditSender;
use AcMarche\MailingList\Filament\Resources\Senders\Pages\ListSenders;
use AcMarche\MailingList\Filament\Resources\Senders\Schemas\SenderForm;
use AcMarche\MailingList\Filament\Resources\Senders\Tables\SendersTable;
use AcMarche\MailingList\Models\Sender;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class SenderResource extends Resource
{
    protected static ?string $model = Sender::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Expediteurs';

    protected static ?string $modelLabel = 'expediteur';

    protected static ?string $pluralModelLabel = 'expediteurs';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return SenderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SendersTable::configure($table);
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
            'edit' => EditSender::route('/{record}/edit'),
        ];
    }
}
