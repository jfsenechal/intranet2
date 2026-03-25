<?php

namespace AcMarche\MailingList\Filament\Resources\Emails\Schemas;

use AcMarche\MailingList\Enums\EmailStatus;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Flex::make([
                    Section::make('Informations')
                        ->label(null)
                        ->schema([
                            Flex::make([
                                TextEntry::make('sender.name')
                                    ->label('Nom de l\'expéditeur'),
                                TextEntry::make('sender.email')
                                    ->label('Expéditeur Email'),
                            ]),
                            TextEntry::make('body')
                                ->label('Contenu')
                                ->html()
                                ->prose()
                                ->columnSpanFull(),
                            RepeatableEntry::make('recipients')
                                ->label('Destinataires')
                                ->schema([
                                    TextEntry::make('name'),
                                    TextEntry::make('email_address'),
                                    TextEntry::make('status')
                                        ->badge()
                                        ->formatStateUsing(fn(EmailStatus $state) => $state->getLabel()),
                                ])
                                ->columns(3)
                                ->columnSpanFull(),
                        ])
                        ->grow(),
                    Section::make('Statut')
                        ->label(null)
                        ->schema([
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn(EmailStatus $state): string => match ($state) {
                                    EmailStatus::Draft => 'gray',
                                    EmailStatus::Sending => 'warning',
                                    EmailStatus::Sent => 'success',
                                    EmailStatus::Failed => 'danger',
                                }),
                            TextEntry::make('total_count')
                                ->label('Recipients'),
                        ])
                        ->grow(false),
                ])->from('md')
                    ->columnSpanFull(),
            ]);
    }
}
