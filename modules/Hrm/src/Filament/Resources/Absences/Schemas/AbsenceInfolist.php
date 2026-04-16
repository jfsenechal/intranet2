<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Absences\Schemas;

use App\Models\User;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class AbsenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                Flex::make([
                    Grid::make(1)
                        ->schema([
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
                            TextEntry::make('notes')
                                ->label('Notes')
                                ->hiddenLabel()
                                ->html()
                                ->prose()
                                ->columnSpanFull(),
                        ]),
                    Grid::make(1)
                        ->visible(fn (): bool => auth()->user() instanceof User)
                        ->schema([
                            Section::make('Etat')
                                ->label(null)
                                ->schema([TextEntry::make('has_resumed')
                                    ->label('Reprise'),
                                    TextEntry::make('clock_updated')
                                        ->label('Pointeuse'),
                                    TextEntry::make('acropole')
                                        ->label('Acropole'),
                                    TextEntry::make('agent_file')
                                        ->label('Dossier agent'),
                                    IconEntry::make('is_closed')
                                        ->label('Clôturé')
                                        ->boolean(), ]),

                        ])
                        ->grow(false),
                ])->from('md')
                    ->columnSpanFull(),

            ]);
    }
}
