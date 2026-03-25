<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Emails\Schemas;

use AcMarche\MailingList\Models\AddressBook;
use AcMarche\MailingList\Models\Contact;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class EmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('username')
                    ->default(fn (): ?string => auth()->user()?->username),
                Select::make('sender_id')
                    ->relationship('sender', 'name', fn ($query) => $query->where('username', auth()->user()?->username))
                    ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->name} <{$record->email}>")
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                TextInput::make('subject')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('attachments')
                    ->multiple()
                    ->disk('public')
                    ->directory('mailing-list/email-attachments')
                    ->visibility('public')
                    ->columnSpanFull(),
                Select::make('address_book_ids')
                    ->label('Address Books')
                    ->multiple()
                    ->options(fn () => AddressBook::query()
                        ->where('username', auth()->user()?->username)
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->dehydrated(false),
                Select::make('contact_ids')
                    ->label('Individual Contacts')
                    ->multiple()
                    ->options(fn () => Contact::query()
                        ->where('username', auth()->user()?->username)
                        ->get()
                        ->mapWithKeys(fn (Contact $contact): array => [
                            $contact->id => "{$contact->first_name} {$contact->last_name} <{$contact->email}>",
                        ]))
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->dehydrated(false),
            ]);
    }
}
