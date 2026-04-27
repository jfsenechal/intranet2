<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Schemas;

use AcMarche\Hrm\Enums\InternTypeEnum;
use AcMarche\Hrm\Enums\ListOptions;
use AcMarche\Hrm\Enums\StatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

final class EmployeeForm
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
                                    ->columns(3)
                                    ->schema([
                                        Select::make('civility')
                                            ->label('Civilité')
                                            ->options([
                                                'monsieur' => 'Monsieur',
                                                'madame' => 'Madame',
                                            ])
                                            ->required(false),
                                        TextInput::make('last_name')
                                            ->label('Nom')
                                            ->required()
                                            ->maxLength(100),
                                        TextInput::make('first_name')
                                            ->label('Prenom')
                                            ->required()
                                            ->maxLength(100),
                                        DatePicker::make('birth_date')
                                            ->label('Date de naissance'),
                                        Toggle::make('show_birthday')
                                            ->label('Afficher anniversaire')
                                            ->default(true),
                                        TextInput::make('national_registry_number')
                                            ->label('Registre national')
                                            ->maxLength(100),
                                    ]),
                                Section::make('Coordonnées')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('address')
                                            ->label('Adresse')
                                            ->maxLength(150)
                                            ->columnSpanFull(),
                                        TextInput::make('postal_code')
                                            ->label('Code postal')
                                            ->numeric(),
                                        TextInput::make('city')
                                            ->label('Ville')
                                            ->maxLength(100),
                                        TextInput::make('private_email')
                                            ->label('Email prive')
                                            ->email()
                                            ->maxLength(255),
                                        TextInput::make('private_phone')
                                            ->label('Téléphone prive')
                                            ->tel()
                                            ->maxLength(150),
                                        TextInput::make('private_mobile')
                                            ->label('GSM prive')
                                            ->tel()
                                            ->maxLength(150),
                                    ]),
                            ]),
                        Tab::make('Emploi')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Fieldset::make('Situation')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('status')
                                            ->label('Statut')
                                            ->options(StatusEnum::class)
                                            ->enum(StatusEnum::class)
                                            ->live(),
                                        Toggle::make('is_archived')
                                            ->label('Archivé'),
                                    ]),
                                Fieldset::make('Dates')
                                    ->columns(3)
                                    ->schema([
                                        DatePicker::make('hired_at')
                                            ->label('Date entree'),
                                        DatePicker::make('left_at')
                                            ->label('Date sortie'),
                                        DatePicker::make('reminder_date')
                                            ->label('Date de rappel'),
                                        DatePicker::make('salary_seniority_date')
                                            ->label('Anciennete pecuniaire'),
                                        DatePicker::make('scale_seniority_date')
                                            ->label('Anciennete echelle'),
                                    ]),
                                Fieldset::make('Barème')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('pay_scale_id')
                                            ->label('Echelle')
                                            ->relationship('payScale', 'name')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('pay_scale_code')
                                            ->label('Code bareme')
                                            ->maxLength(255),
                                        Select::make('allowance')
                                            ->label('Indemnité')
                                            ->helperText('Montant Foyer/Résid')
                                            ->options(ListOptions::allowances()),
                                        TextInput::make('local_unit')
                                            ->label('Unite locale')
                                            ->maxLength(100),
                                    ]),
                            ]),
                        Tab::make('Sante')
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                Select::make('health_insurance_id')
                                    ->label('Mutuelle')
                                    ->relationship('healthInsurance', 'name')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('insurance_affiliation')
                                    ->label('Affiliation mutuelle')
                                    ->maxLength(100),
                            ]),
                        Tab::make('Notes')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                RichEditor::make('notes')
                                    ->label('Remarques')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Candidat')
                            ->icon('heroicon-o-identification')
                            ->columns(2)
                            ->schema([
                                Select::make('diploma_level')
                                    ->label('Niveau de diplôme')
                                    ->options(ListOptions::getNiveauxDiplomes()),
                                TextInput::make('diploma_nature')
                                    ->label('Nature du diplôme')
                                    ->maxLength(200),
                            ]),
                        Tab::make('Stagiaire')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->columns(2)
                            ->schema([
                                Select::make('intern_type')
                                    ->label('Demande de stage')
                                    ->options(InternTypeEnum::class)
                                    ->enum(InternTypeEnum::class),
                                Select::make('diploma_level_simplified')
                                    ->label('Niveau de diplôme')
                                    ->options(ListOptions::getNiveauxDiplomesSimplifies()),
                                FileUpload::make('candidate_file_name')
                                    ->label('Document du stagiaire')
                                    ->disk('public')
                                    ->directory(config('hrm.uploads.candidates')),
                            ]),
                        Tab::make('Etudiant')
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                TextInput::make('diploma_nature')
                                    ->label('Nature du diplôme')
                                    ->maxLength(200),
                                Select::make('diploma_level')
                                    ->label('Niveau de diplôme')
                                    ->options(ListOptions::getNiveauxDiplomes()),
                            ]),
                        Tab::make('Photo')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory(config('hrm.uploads.photos'))
                                    ->imageEditor(),
                            ]),
                    ]),
            ]);
    }
}
