<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AbsenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Agent')
                    ->schema([
                        Select::make('employee_id')
                            ->label('Agent')
                            ->relationship('employee', 'last_name')
                            ->getOptionLabelFromRecordUsing(fn ($record): string => $record->last_name.' '.$record->first_name)
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                Fieldset::make('Periode')
                    ->columns(4)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Date de debut'),
                        DatePicker::make('end_date')
                            ->label('Date de fin'),
                        DatePicker::make('reminder_date')
                            ->label('Date de rappel'),
                        DatePicker::make('closed_date')
                            ->label('Date de cloture'),
                    ]),
                Fieldset::make('Motif')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reason')
                            ->label('Raison')
                            ->maxLength(255),
                        TextInput::make('ssa')
                            ->label('SSA')
                            ->maxLength(5),
                    ]),
                Fieldset::make('Options')
                    ->columns(4)
                    ->schema([
                        Select::make('has_resumed')
                            ->label('Reprise')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ]),
                        Select::make('clock_updated')
                            ->label('Pointeuse')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ]),
                        Select::make('acropole')
                            ->label('Acropole')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ]),
                        Select::make('agent_file')
                            ->label('Dossier agent')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ]),
                        Toggle::make('is_closed')
                            ->label('Cloture'),
                    ]),
                Section::make('Notes')
                    ->schema([
                        RichEditor::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
