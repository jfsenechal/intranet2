<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AbsenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Période')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Date de début')
                            ->date('d/m/Y'),
                        TextEntry::make('end_date')
                            ->label('Date de fin')
                            ->date('d/m/Y'),
                        TextEntry::make('reminder_date')
                            ->label('Date de rappel')
                            ->date('d/m/Y'),
                        TextEntry::make('closed_date')
                            ->label('Date de clôture')
                            ->date('d/m/Y'),
                    ]),
                Section::make('Motif')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('reason')
                            ->label('Raison'),
                        TextEntry::make('ssa')
                            ->label('SSA'),
                    ]),
                Section::make('Options')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('has_resumed')
                            ->label('Reprise'),
                        TextEntry::make('clock_updated')
                            ->label('Pointeuse'),
                        TextEntry::make('acropole')
                            ->label('Acropole'),
                        TextEntry::make('agent_file')
                            ->label('Dossier agent'),
                        IconEntry::make('is_closed')
                            ->label('Clôturé')
                            ->boolean(),
                    ]),
                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->html()
                            ->prose()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
