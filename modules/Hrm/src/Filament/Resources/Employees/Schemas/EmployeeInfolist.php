<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

final class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Employee')
                    ->tabs([
                        Tab::make('Informations personnelles')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Identite')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('civility')
                                            ->label('Civilité'),
                                        TextEntry::make('birth_date')
                                            ->label('Date de naissance')
                                            ->date('d/m/Y'),
                                        IconEntry::make('show_birthday')
                                            ->label('Afficher la date d\' anniversaire')
                                            ->boolean(),
                                        TextEntry::make('national_registry_number')
                                            ->label('Registre national'),
                                    ]),
                                Section::make('Coordonnées')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('address')
                                            ->label('Adresse')
                                            ->columnSpanFull(),
                                        TextEntry::make('postal_code')
                                            ->label('Code postal'),
                                        TextEntry::make('city')
                                            ->label('Ville'),
                                        TextEntry::make('email')
                                            ->label('Email prive')
                                            ->icon('heroicon-o-envelope'),
                                        TextEntry::make('professional_email')
                                            ->label('Email professionnel')
                                            ->icon('heroicon-o-envelope'),
                                        TextEntry::make('private_phone')
                                            ->label('Telephone prive')
                                            ->icon('heroicon-o-phone'),
                                        TextEntry::make('private_mobile')
                                            ->label('GSM prive')
                                            ->icon('heroicon-o-device-phone-mobile'),
                                    ]),
                            ]),
                        Tab::make('Emploi')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Fieldset::make('Situation')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('job_title')
                                            ->label('Fonction'),
                                        TextEntry::make('status')
                                            ->label('Statut')
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'active' => 'success',
                                                'retired' => 'info',
                                                'terminated' => 'danger',
                                                'suspended' => 'warning',
                                                default => 'gray',
                                            }),
                                        IconEntry::make('is_archived')
                                            ->label('Archivé')
                                            ->boolean(),
                                    ]),
                                Fieldset::make('Dates')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('hired_at')
                                            ->label('Date entree')
                                            ->date('d/m/Y'),
                                        TextEntry::make('left_at')
                                            ->label('Date sortie')
                                            ->date('d/m/Y'),
                                        TextEntry::make('reminder_date')
                                            ->label('Date de rappel')
                                            ->date('d/m/Y'),
                                        TextEntry::make('salary_seniority_date')
                                            ->label('Anciennete pecuniaire')
                                            ->date('d/m/Y'),
                                        TextEntry::make('scale_seniority_date')
                                            ->label('Anciennete echelle')
                                            ->date('d/m/Y'),
                                    ]),
                                Fieldset::make('Bareme')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('payScale.name')
                                            ->label('Echelle'),
                                        TextEntry::make('pay_scale_code')
                                            ->label('Code bareme'),
                                        TextEntry::make('allowance')
                                            ->label('Indemnite'),
                                        TextEntry::make('local_unit')
                                            ->label('Unite locale'),
                                    ]),
                            ]),
                        Tab::make('Sante')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                TextEntry::make('healthInsurance.name')
                                    ->label('Mutuelle'),
                                TextEntry::make('insurance_affiliation')
                                    ->label('Affiliation mutuelle'),
                            ]),
                        Tab::make('Notes')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextEntry::make('notes')
                                    ->label('Remarques')
                                    ->html()
                                    ->prose()
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Photo')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('photo')
                                    ->label('Photo')
                                    ->disk('public')
                                    ->imageHeight(300),
                            ]),
                        Tab::make('Compte informatique')
                            ->icon(Heroicon::OutlinedUserCircle)
                            ->schema([
                                TextEntry::make('username')
                                    ->label('Nom utilisateur'),
                            ]),
                    ]),
            ]);
    }
}
