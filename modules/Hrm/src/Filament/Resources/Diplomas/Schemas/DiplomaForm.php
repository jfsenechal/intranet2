<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Diplomas\Schemas;

use AcMarche\Hrm\Models\Employee;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class DiplomaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Agent et diplôme')
                    ->columns(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label('Agent')
                            ->relationship('employee', 'last_name')
                            ->getOptionLabelFromRecordUsing(
                                fn (Employee $record): string => $record->last_name.' '.$record->first_name
                            )
                            ->searchable(['last_name', 'first_name'])
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Intitulé')
                            ->required()
                            ->maxLength(150),
                        FileUpload::make('certificate_file')
                            ->label('Fichier attestation')
                            ->disk('public')
                            ->visibility('public')
                            ->directory(config('hrm.uploads.diplomas'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
