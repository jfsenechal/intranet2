<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Schemas;

use AcMarche\Agent\Mail\ProfileRequestMail;
use AcMarche\Hrm\Models\Employee;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

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
                                Grid::make(12)
                                    ->schema([
                                        ImageEntry::make('photo')
                                            ->label('Photo')
                                            ->disk('public')
                                            ->imageHeight(260)
                                            ->defaultImageUrl(fn (Employee $record): string => 'https://ui-avatars.com/api/?size=256&name='.urlencode(mb_trim($record->first_name.' '.$record->last_name)))
                                            ->columnSpan(3),
                                        Fieldset::make('Coordonnées')
                                            ->columns(2)
                                            ->columnSpan(9)
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
                                Section::make('Identité')
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
                                Fieldset::make('Barème')
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
                        Tab::make('Santé')
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
                                TextEntry::make('profile.username')
                                    ->label('Nom utilisateur')
                                    ->visible(fn (Employee $record): bool => $record->profile !== null)
                                    ->placeholder('—'),
                                TextEntry::make('no_profile')
                                    ->label('Compte informatique')
                                    ->state('Aucun profil informatique pour cet agent.')
                                    ->visible(fn (Employee $record): bool => $record->profile === null)
                                    ->suffixAction(
                                        Action::make('requestProfile')
                                            ->label('Demander un compte informatique')
                                            ->icon(Heroicon::OutlinedEnvelope)
                                            ->iconPosition(IconPosition::After)
                                            ->link()
                                            ->color('primary')
                                            ->requiresConfirmation()
                                            ->modalHeading('Demander un compte informatique')
                                            ->modalDescription('Un e-mail sera envoyé au service informatique.')
                                            ->action(function (Employee $record): void {
                                                $to = config('agent.informatique_email');
                                                if (empty($to)) {
                                                    Notification::make()
                                                        ->title('Adresse informatique non configurée')
                                                        ->danger()
                                                        ->send();

                                                    return;
                                                }

                                                Mail::to($to)->send(new ProfileRequestMail($record));

                                                Notification::make()
                                                    ->title('Demande envoyée au service informatique')
                                                    ->success()
                                                    ->send();
                                            }),
                                    ),
                            ]),
                    ]),
            ]);
    }
}
