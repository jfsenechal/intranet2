<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AgentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identité')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('last_name')->label('Nom'),
                        TextEntry::make('first_name')->label('Prénom'),
                        TextEntry::make('username')->label('Identifiant')->copyable(),
                        TextEntry::make('employee_id')->label('Matricule RH'),
                        TextEntry::make('location')->label('Emplacement'),
                        IconEntry::make('no_mail')->label('Pas de mailbox'),
                        TextEntry::make('notes')->label('Remarques')->columnSpanFull(),
                    ]),
                Section::make('Accès')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('emails')
                            ->label('Mailboxes partagées')
                            ->listWithLineBreaks(),
                        TextEntry::make('supervisors')
                            ->label('Responsables')
                            ->listWithLineBreaks(),
                    ]),
                Grid::make(2)->schema([
                    Section::make('Matériel')
                        ->relationship('hardware')
                        ->schema([
                            TextEntry::make('existing_pc')->label('PC existant'),
                            TextEntry::make('new_pc')->label('Nouveau PC'),
                            IconEntry::make('vpn')->label('VPN'),
                            TextEntry::make('other')->label('Autre'),
                        ]),
                    Section::make('Téléphonie')
                        ->relationship('phone')
                        ->schema([
                            TextEntry::make('existing_number')->label('Numéro existant'),
                            TextEntry::make('mobile_number')->label('Numéro mobile'),
                            IconEntry::make('new_number')->label('Nouveau numéro'),
                            IconEntry::make('external_number')->label('Numéro extérieur'),
                        ]),
                ]),
            ]);
    }
}
