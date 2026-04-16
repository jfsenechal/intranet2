<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Schemas;

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
                Section::make('Agent et formation')
                    ->columns(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label('Agent')
                            ->relationship('employee', 'last_name')
                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->last_name.' '.$record->first_name)
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Intitule')
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
                            ->label('Duree (heures)')
                            ->numeric()
                            ->suffix('heures'),
                    ]),
                Fieldset::make('Dates')
                    ->columns(4)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Date de debut'),
                        DatePicker::make('end_date')
                            ->label('Date de fin'),
                        DatePicker::make('college_date')
                            ->label('Date college'),
                        DatePicker::make('reminder_date')
                            ->label('Date de rappel'),
                    ]),
                Fieldset::make('Accord')
                    ->columns(2)
                    ->schema([
                        TextInput::make('granted_by')
                            ->label('Accorde par')
                            ->maxLength(255),
                        DatePicker::make('granted_at')
                            ->label('Accorde le'),
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
                            ->directory(config('hrm.uploads.formations')),
                    ]),
                Section::make('Description')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),
                Toggle::make('is_closed')
                    ->label('Cloture'),
            ]);
    }
}
