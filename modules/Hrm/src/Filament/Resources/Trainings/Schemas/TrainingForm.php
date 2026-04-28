<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Schemas;

use AcMarche\Hrm\Enums\ListOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Formation')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Intitulé')
                            ->required()
                            ->maxLength(150),
                        Select::make('training_type')
                            ->label('Type de formation')
                            ->options([
                                'type1' => 'Type 1',
                                'type2' => 'Type 2',
                                'type3' => 'Type 3',
                            ])
                            ->required(),
                        TextInput::make('duration_hours')
                            ->label('Durée (heures)')
                            ->numeric()
                            ->suffix('heures'),
                    ]),
                Fieldset::make('Dates')
                    ->columns(4)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Date de début'),
                        DatePicker::make('end_date')
                            ->label('Date de fin'),
                        DatePicker::make('college_date')
                            ->label('Date de Collège'),
                        DatePicker::make('reminder_date')
                            ->label('Date de rappel'),
                    ]),
                Fieldset::make('Accord')
                    ->columns(2)
                    ->schema([
                        Select::make('granted_by')
                            ->label('Accorde par')
                            ->options(ListOptions::getAccordePar()),
                        DatePicker::make('granted_at')
                            ->label('Accordé le'),
                    ]),
                Fieldset::make('Attestation')
                    ->columns(3)
                    ->schema([
                        Toggle::make('certificate_received')
                            ->label('Attestation recue'),
                        DatePicker::make('certificate_received_at')
                            ->label('Recue le'),
                        FileUpload::make('certificate_file')
                            ->label('Fichier attestation')
                            ->disk('public')
                            ->directory(config('hrm.uploads.formations'))
                            ->columnSpanFull(),
                    ]),
                Section::make('Description')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Description')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ]),
                Toggle::make('is_closed')
                    ->label('Clôturée'),
            ]);
    }
}
