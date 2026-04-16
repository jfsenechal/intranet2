<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Agent et employeur')
                    ->columns(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label('Agent')
                            ->relationship('employee', 'last_name')
                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->last_name.' '.$record->first_name)
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('employer_id')
                            ->label('Employeur')
                            ->relationship('employer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('direction_id')
                            ->label('Direction')
                            ->relationship('direction', 'title')
                            ->searchable()
                            ->preload(),
                        Select::make('service_id')
                            ->label('Service')
                            ->relationship('service', 'title')
                            ->searchable()
                            ->preload(),
                    ]),
                Section::make('Details du contrat')
                    ->columns(3)
                    ->schema([
                        Select::make('contract_type_id')
                            ->label('Type de contrat')
                            ->relationship('contractType', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('contract_nature_id')
                            ->label('Nature du contrat')
                            ->relationship('contractNature', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('pay_scale_id')
                            ->label('Echelle')
                            ->relationship('payScale', 'title')
                            ->searchable()
                            ->preload(),
                        TextInput::make('job_title')
                            ->label('Fonction')
                            ->maxLength(250),
                        TextInput::make('status')
                            ->label('Statut')
                            ->maxLength(250),
                        TextInput::make('work_regime')
                            ->label('Regime de travail')
                            ->numeric()
                            ->suffix('%'),
                        TextInput::make('hourly_regime')
                            ->label('Regime horaire')
                            ->maxLength(255),
                    ]),
                Fieldset::make('Dates')
                    ->columns(3)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Date de debut'),
                        DatePicker::make('end_date')
                            ->label('Date de fin'),
                        DatePicker::make('reminder_date')
                            ->label('Date de rappel'),
                    ]),
                Fieldset::make('Remplacement')
                    ->columns(2)
                    ->schema([
                        Select::make('is_replacement')
                            ->label('Remplacement')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ]),
                        Select::make('replaces_id')
                            ->label('Remplace')
                            ->relationship('replaces', 'last_name')
                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->last_name.' '.$record->first_name)
                            ->searchable()
                            ->preload(),
                    ]),
                Fieldset::make('Options')
                    ->columns(4)
                    ->schema([
                        Toggle::make('is_closed')
                            ->label('Cloture'),
                        Toggle::make('is_amendment')
                            ->label('Avenant'),
                        Toggle::make('is_suspended')
                            ->label('Suspension'),
                    ]),
                Section::make('Documents')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('file1_name')
                            ->label('Document 1')
                            ->disk('public')
                            ->directory(config('hrm.uploads.contracts')),
                        FileUpload::make('file2_name')
                            ->label('Document 2')
                            ->disk('public')
                            ->directory(config('hrm.uploads.contracts')),
                    ]),
                RichEditor::make('college')
                    ->label('College')
                    ->columnSpanFull(),
            ]);
    }
}
