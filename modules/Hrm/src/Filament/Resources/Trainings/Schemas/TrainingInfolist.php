<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Trainings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class TrainingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Agent et formation')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('employee.full_name')
                            ->label('Agent'),
                        TextEntry::make('name')
                            ->label('Intitulé'),
                        TextEntry::make('training_type')
                            ->label('Type de formation')
                            ->badge(),
                        TextEntry::make('duration_hours')
                            ->label('Durée')
                            ->suffix(' heures'),
                    ]),
                Fieldset::make('Dates')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Date de début')
                            ->date('d/m/Y'),
                        TextEntry::make('end_date')
                            ->label('Date de fin')
                            ->date('d/m/Y'),
                        TextEntry::make('college_date')
                            ->label('Date collège')
                            ->date('d/m/Y'),
                        TextEntry::make('reminder_date')
                            ->label('Date de rappel')
                            ->date('d/m/Y'),
                    ]),
                Fieldset::make('Accord')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('granted_by')
                            ->label('Accordé par'),
                        TextEntry::make('granted_at')
                            ->label('Accordé le')
                            ->date('d/m/Y'),
                    ]),
                Fieldset::make('Attestation')
                    ->columns(3)
                    ->schema([
                        IconEntry::make('certificate_received')
                            ->label('Attestation reçue')
                            ->boolean(),
                        TextEntry::make('certificate_received_at')
                            ->label('Reçue le')
                            ->date('d/m/Y'),
                    ]),
                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->html()
                            ->prose()
                            ->columnSpanFull(),
                    ]),
                IconEntry::make('is_closed')
                    ->label('Clôturé')
                    ->boolean(),
            ]);
    }
}
