<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

final class AgentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Agent')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Identité')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('last_name')
                                            ->label('Nom')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('first_name')
                                            ->label('Prénom')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('username')
                                            ->label('Identifiant')
                                            ->maxLength(255),
                                        TextInput::make('employee_id')
                                            ->label('Matricule RH')
                                            ->numeric(),
                                        TextInput::make('location')
                                            ->label('Emplacement')
                                            ->columnSpanFull(),
                                        Toggle::make('no_mail')
                                            ->label('Pas de mailbox personnelle'),
                                        Textarea::make('notes')
                                            ->label('Remarques')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Accès')
                            ->icon('heroicon-o-key')
                            ->schema([
                                Section::make('Mailboxes et responsables')
                                    ->columns(2)
                                    ->schema([
                                        TagsInput::make('emails')
                                            ->label('Mailboxes partagées'),
                                        TagsInput::make('supervisors')
                                            ->label('Responsables'),
                                    ]),
                            ]),
                        Tab::make('Matériel')
                            ->icon('heroicon-o-computer-desktop')
                            ->schema([
                                Fieldset::make('Matériel informatique')
                                    ->relationship('hardware')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('existing_pc')
                                            ->label('PC existant'),
                                        TextInput::make('new_pc')
                                            ->label('Nouveau PC'),
                                        Toggle::make('vpn')
                                            ->label('VPN'),
                                        Textarea::make('other')
                                            ->label('Autre')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Téléphonie')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Fieldset::make('Téléphonie')
                                    ->relationship('phone')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('existing_number')
                                            ->label('Numéro existant'),
                                        TextInput::make('mobile_number')
                                            ->label('Numéro mobile'),
                                        Toggle::make('new_number')
                                            ->label('Nouveau numéro'),
                                        Toggle::make('external_number')
                                            ->label('Numéro extérieur'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
