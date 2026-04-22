<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Profiles\Schemas;

use AcMarche\Security\Repository\LdapRepository;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

final class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Wizard::make([
                    Step::make('Agent')
                        ->icon(Heroicon::OutlinedUserCircle)
                        ->columns(2)
                        ->schema([
                            TextInput::make('username')
                                ->label('Identifiant Ldap')
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->maxLength(255),
                            TextInput::make('location')
                                ->label('Dans quel local travaillera-t-il ?')
                                ->columnSpanFull(),
                            TagsInput::make('supervisors')
                                ->label('Responsable(s)')
                                ->columnSpanFull(),
                        ]),
                    Step::make('Email')
                        ->icon(Heroicon::OutlinedEnvelope)
                        ->schema([
                            Toggle::make('no_mail')
                                ->label('Pas de mail professionnel nécessaire')
                                ->helperText('Cet agent n\'a pas besoin d\'une adresse mail à son nom'),
                            CheckboxList::make('emails')
                                ->label('Mailboxes partagées')
                                ->options(fn(): array => LdapRepository::listsAsOptions())
                                ->columns(2)
                                ->searchable()
                                ->bulkToggleable(),
                        ]),
                    Step::make('Matériel')
                        ->icon(Heroicon::OutlinedComputerDesktop)
                        ->schema([
                            Fieldset::make('Matériel informatique')
                                ->relationship('hardware')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('existing_pc')
                                        ->label('Numéro de ce PC')
                                        ->helperText("Utilisation d'un PC existant ?, si oui indiquez son numéro"),
                                    Select::make('new_pc')
                                        ->label('Nouveau PC nécessaire ?')
                                        ->options([
                                            'Non' => 'Non',
                                            'Oui' => 'Oui',
                                            'Oui, un portable' => 'Oui, un portable',
                                        ]),
                                    Toggle::make('vpn')
                                        ->label('L\'agent fera-t-il du télétravail ?')
                                        ->helperText('Si oui, il aura besoin d\'un VPN'),
                                    Textarea::make('other')
                                        ->label('Autre matériel')
                                        ->rows(5)
                                        ->columnSpanFull(),
                                ]),
                        ]),
                    Step::make('Téléphonie')
                        ->icon(Heroicon::OutlinedPhone)
                        ->schema([
                            Fieldset::make('Téléphonie')
                                ->relationship('phone')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('existing_number')
                                        ->label('Numéro de téléphone')
                                        ->helperText("Reprise d'un numéro existant ?"),
                                    TextInput::make('mobile_number')
                                        ->label('Numéro de mobile professionnel')
                                        ->helperText('Format: +32475886322')
                                        ->regex('/^\+?[0-9\s]{6,20}$/'),
                                    Toggle::make('new_number')
                                        ->label('Nouveau téléphone nécessaire ?'),
                                    Toggle::make('external_number')
                                        ->label('Numéro direct')
                                        ->helperText("Doit-il être accessible depuis l'extérieur ?"),
                                ]),
                        ]),
                    Step::make('Remarques')
                        ->icon(Heroicon::OutlinedDocumentText)
                        ->schema([
                            Textarea::make('notes')
                                ->label('Remarques')
                                ->rows(5)
                                ->columnSpanFull(),
                        ]),
                ])
                    ->skippable()
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
