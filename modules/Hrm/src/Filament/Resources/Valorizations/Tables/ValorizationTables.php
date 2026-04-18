<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Valorizations\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class ValorizationTables
{
    public static function relation(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('employer_name')
                    ->label('Employeur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('duration')
                    ->label('Durée')
                    ->sortable(),
                TextColumn::make('regime')
                    ->label('Regime')
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('content')
                    ->label('Contenu')
                    ->limit(60)
                    ->toggleable(),
            ]);
    }
}
